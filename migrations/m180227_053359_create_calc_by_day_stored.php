<?php

use yii\db\Migration;

/**
 * Class m180227_053359_create_calc_by_day_stored
 */
class m180227_053359_create_calc_by_day_stored extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(<<<SQL
CREATE FUNCTION yii2task2.prc_calc_by_day_pregen(calcdate date)
  RETURNS integer AS
\$BODY$
DECLARE
BEGIN
    
    DROP TABLE IF EXISTS tmp_prc_calc_by_day_pregen;
    CREATE TABLE tmp_prc_calc_by_day_pregen (
        manager_id integer,
        calls integer 
    )
    WITH (OIDS=FALSE)
    ;
    
    INSERT INTO tmp_prc_calc_by_day_pregen(manager_id, calls)
    select
      manager_id, count(*) as calls
    from yii2task2.calls
    where dt::date = calcdate
    group by manager_id;
    
    UPDATE "yii2task2"."calls_by_day" self
    SET 
        "calls" = t.calls
    FROM (
        SELECT manager_id, calls
        FROM tmp_prc_calc_by_day_pregen self
        WHERE EXISTS (
            SELECT 1 
            FROM "yii2task2"."calls_by_day" t
            WHERE t.manager_id = self.manager_id AND t.date = calcdate
        )
    ) t
    WHERE
        t.manager_id = self.manager_id AND calcdate = self.date AND (
            t.calls != self.calls
        );
    
    INSERT INTO "yii2task2"."calls_by_day" (date, manager_id, calls)
        SELECT calcdate, manager_id, calls
        FROM tmp_prc_calc_by_day_pregen self
        WHERE NOT EXISTS (
            SELECT 1 
            FROM "yii2task2"."calls_by_day" t
            WHERE t.manager_id = self.manager_id AND t.date = calcdate
        );
    
    return 1;
END;
 \$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
SQL
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute(<<<SQL
DROP FUNCTION yii2task2.prc_calc_by_day_pregen(date)
SQL
        );
    }
}
