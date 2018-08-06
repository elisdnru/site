<?php

class CommentsCommand extends CConsoleCommand
{
    public function actionVacuum()
    {
        $log = new ConsoleLogger();
        $db = Yii::app()->db;

        $rows = $db->createCommand('SELECT id FROM {{comment}} ORDER BY id')->queryAll();

        $success = true;
        $auto = 0;

        foreach ($rows as $i => $row) {
            $old_id = $row['id'];
            $new_id = $i + 1;
            $auto = $new_id + 1;

            $log->write('Comment ' . $old_id);

            if ($old_id != $new_id) {
                $tr = $db->beginTransaction();

                $success = $db->createCommand('UPDATE {{comment}} SET id = :new_id WHERE id = :old_id')->execute([
                        'old_id' => $old_id,
                        'new_id' => $new_id,
                    ]) && $success;

                $db->createCommand('UPDATE {{comment}} SET parent_id = :new_id WHERE parent_id = :old_id')->execute([
                    'old_id' => $old_id,
                    'new_id' => $new_id,
                ]);

                if ($success) {
                    $log->writelnSuccess($new_id);
                    $tr->commit();
                } else {
                    $log->writelnError();
                    $tr->rollback();
                    break;
                }
            } else {
                $log->writelnSuccess('Skip');
            }
        }

        if ($success) {
            $log->write('Set AUTO_INCREMENT=' . $auto);
            $db->createCommand('ALTER TABLE {{comment}} AUTO_INCREMENT = ' . $auto);
            $log->writelnSuccess();
        }
    }
}
