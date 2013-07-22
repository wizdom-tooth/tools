<?php

class MultiProcess
{
	/** @var Array 子プロセスで実行される関数の引数 */
	private $_args = array();

	/** @var Integer 同時に起動する子プロセスの最大数 */
	private $_maxProcessNum = 3;

	/** @var Integer 同時に起動する子プロセスの最大数 */
	private $_timeout = 300;

	/**
	 * 子プロセスで実行される関数の引数を設定する
	 * @param $max_process_num
	 */
	public function setArgs(array $args)
	{
		$this->_args = $args;
	}

	/**
	 * 同時に起動する子プロセスの最大数を設定する
	 * @param $max_process_num
	 */
	public function setMaxProcessNum($maxProcessNum)
	{
		$this->_maxProcessNum = (int)$maxProcessNum;
	}

	/**
	 * タイムアウト秒数を設定する
	 * @param $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->_timeout = (int)$timeout;
	}

	/**
	 * 子プロセスで実行されるコールバックを設定する。
	 * @param $callback
	 */
	public function setWork($callback)
	{
		$this->work = $callback;
	}

	/**
	 * コンストラクタ。
	 */
	public function __construct()
	{
		//シグナルにシグナルハンドラを登録
		pcntl_signal(SIGTERM, array($this, '_sigHandler'));
		pcntl_signal(SIGHUP, array($this, '_sigHandler'));
		pcntl_signal(SIGUSR1, array($this, '_sigHandler'));
		pcntl_signal(SIGALRM, array($this, '_sigHandler'));

		//子プロセスで実行する処理を登録
		$this->work = array($this, 'work');
	}

	/**
	 * デフォルトのシグナルハンドラ。
	 *
	 * @param Integer $signo シグナル
	 */
	private function _sigHandler($signo)
	{
		switch ($signo)
		{
			case SIGTERM: //シャットダウン
				echo "shutdown...\n";
				exit;
				break;
			case SIGHUP: //リブート
				echo "reboot...\n";
				break;
			case SIGUSR1: //ユーザーシグナル
				echo "SIGUSER($signo)\n";
				break;
			case SIGALRM: //アラーム
				echo "alarm...\n";
				exit;
				break;
			default: //その他
				echo "Other signal: " . $signo . "\n";
		}
	}

	/**
	 * 子プロセスで実行される処理。
	 * @param $arg
	 */
	protected function work($arg)
	{
		/* do anything ...
		$sec = 1;
		echo time()." : do work for arg($arg). do nothing but sleep $sec sec.\n";
		sleep($sec);
		echo time()." : do work for arg($arg). finished.\n";
		*/
	}

	/**
	 * マルチプロセス実行。
	 */
	final public function run()
	{
		$pchild = 0; //現在起動している子プロセス数
		$pnum = 0; //プロセスナンバー
		$pend = 0; //終了した子プロセス数

		while(TRUE)
		{
			if (count($this->_args) <= $pend) //終了判定
			{
				echo "loop ends.\n";
				break;
			}
			if ( //最大起動数を越えない場合
				$pchild < $this->_maxProcessNum &&
				$pnum < count($this->_args)
			)
			{
				//子プロセス生成
				$pid = pcntl_fork();
				if ($pid == -1) //エラー発生時(子プロセスのforkに失敗した場合)
				{
					throw new Exception('Failed forc process.');
				}
				else if ($pid) //親プロセス
				{
					//起動数を追加
					$pchild++;
					$pnum++;
				}
				else //子プロセス
				{
					$arg = $this->_args[$pnum];
					//TIMEOUT 秒後に強制終了
					pcntl_alarm($this->_timeout);
					// 子プロセスで行う仕事
					if (!is_array($this->work)) //外部クロージャが設定されている場合
					{
						$function = $this->work;
						$function($arg);
					}
					else //デフォルト処理を実行、または外部インスタンスのメソッドを実行( $mp->setWork(array($obj,"obj_function")); )
					{
						$obj = $this->work[0];
						$func = $this->work[1];
						$obj->$func($arg);
					}
					// 子プロセスを終了
					exit(0);
				}
			}
			else //最大起動数を越えた場合
			{
				echo "waiting.\n";
				$pid = pcntl_waitpid(-1, $status, WUNTRACED);
				$pchild--;
				$pend++;
				echo "$pid stopped.\n";
			}
		}
		echo "kicked all.\n";
	}
}
