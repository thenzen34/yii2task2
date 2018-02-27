<?php

use yii\db\Migration;

/**
 * Class m180227_054919_create_calc_by_month_stored
 */
class m180227_054919_create_calc_by_month_stored extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(<<<SQL
CREATE FUNCTION yii2task2.prc_calc_by_month_pregen(calcdate date)
  RETURNS integer AS
\$BODY$
DECLARE
  date_from date;
  date_to date;
BEGIN

    date_from = (to_char(calcdate, '01-MM-YYYY'))::date;
    date_to = (date_from + '1 month'::interval); 
    
    DROP TABLE IF EXISTS tmp_prc_calc_by_month_pregen;
    CREATE TABLE tmp_prc_calc_by_month_pregen (
        manager_id integer,
        calls integer, 
        bonus_id integer
    )
    WITH (OIDS=FALSE)
    ;
    
    INSERT INTO tmp_prc_calc_by_month_pregen(manager_id, calls, bonus_id)
    select
      manager_id, calls, b.id as bonus_id
    from (
        select
              manager_id, sum(calls) as calls
            from yii2task2.calls_by_day
            where date >= date_from and date < date_to
            group by manager_id
        ) t
    left join yii2task2.bonus b on t.calls >= b.from and t.calls <= b.to;
    
    UPDATE "yii2task2"."calls_by_month" self
    SET 
        "calls" = t.calls, "bonus_id" = t.bonus_id 
    FROM (
        SELECT manager_id, calls, bonus_id
        FROM tmp_prc_calc_by_month_pregen self
        WHERE EXISTS (
            SELECT 1 
            FROM "yii2task2"."calls_by_month" t
            WHERE t.manager_id = self.manager_id AND t.date = date_from
        )
    ) t
    WHERE
        t.manager_id = self.manager_id AND date_from = self.date AND (
            t.calls != self.calls OR t.bonus_id != self.bonus_id
        );
    
    INSERT INTO "yii2task2"."calls_by_month" (date, manager_id, calls, bonus_id)
        SELECT date_from, manager_id, calls, bonus_id
        FROM tmp_prc_calc_by_month_pregen self
        WHERE NOT EXISTS (
            SELECT 1 
            FROM "yii2task2"."calls_by_month" t
            WHERE t.manager_id = self.manager_id AND t.date = date_from
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
DROP FUNCTION yii2task2.prc_calc_by_month_pregen(date)
SQL
        );
    }
}
