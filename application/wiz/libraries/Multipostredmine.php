<?php

require_once('MultiProcess.php');

class Multipostredmine extends MultiProcess {

    const SRC_FILE_PATH_INTORODUCTION = '/home/wiz/work/wiz/migration/introduction.csv';
    const MULTI_WORK_BLOCK_SIZE = 300;

    public function __construct()
    {
        parent::__construct();
		$this->load->database('redmine');

        // 移行ソースデータファイルチェック
        if (
            ! file_exists(self::SRC_FILE_PATH_INTORODUCTION) ||
            ! is_readable(self::SRC_FILE_PATH_INTORODUCTION)
        )
        {
            echo 'ERROR: request src file is not readable.'."\n";
            echo 'XXXXXXXXXXXXXX set [error handling process] afrer few XXXXXXXXXXXXXXX'."\n";
        }

        $line_num = sizeof(file(self::SRC_FILE_PATH_INTORODUCTION));
        $block_num = ceil($line_num / self::MULTI_WORK_BLOCK_SIZE);

		$args = array();
        for  ($i = 0; $i < $block_num; $i++)
        {
			$args[] = $i * self::MULTI_WORK_BLOCK_SIZE;
        }
		$this->setArgs($args);
	}

    /**
     * 子プロセスで実行される処理。
     * @param $args
     */
    protected function work($arg)
    {
		$sql = "select src from tmp limit ${arg}, ".self::MULTI_WORK_BLOCK_SIZE;
		$query = $this->db->query($sql);
		if ($query->num_rows() === 0)
		{
			echo 'src data is not found';
		}
		else
		{
			foreach ($query->result() as $row)
			{
				$explode(',', $row);
			}
		}
		//var_dump($arg);
        /* do anything ...
        $sec = 1;
        echo time()." : do work for args($args). do nothing but sleep $sec sec.\n";
        sleep($sec);
        echo time()." : do work for args($args). finished.\n";
        */
    }
}
