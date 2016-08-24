<?php
namespace BOWZU_for_PHPPO;
use phppo\system\systemProcessing as systemProcessing;
use phppo\command\plugincommand\addcommand as addcommand;
$pluginAddCommand = new addcommand;
$pluginAddCommand -> addcommand("BOWZU-for-PHPPO","bowzu","plugin","アプリケーション、BOWZU-for-PHPPOを起動します。","<args>");
/**
 *
 */
class game extends systemProcessing{

	function __construct(){
		# code...
	}

	public function onCommand(){
		global $poPath;
		$this->dir = $poPath . "/root/bin/BOWZU-for-PHPPO";
		if (!is_dir($this->dir)) {
			include 'install.php';
		}
		$creates = array(
			"BOWZU_LOG.log",
			"saves.log",
			"darega.txt",
			"dokode.txt",
			"naniwo.txt",
			"dousuru.txt"
			);

		foreach ($creates as $value) {
			$path = $this->dir . "/{$value}";
			if (!is_file($path)) {
				$this->info("Creating {$value}...");
				touch($path);
			}
		}
		$this->addlog("ファイルを確認しています...");
		foreach ($creates as $value) {
			$path = $this->dir . "/{$value}";
			$check = trim(file_get_contents($path));
			if ($check = "") {
				$this->error("{$value}内が空です！\nコミュニティーからサンプルをコピペするなどをして{$value}内に文字を入れてみましょう！");
			}
		}
		$path = $this->dir . '/BOWZU_LOG.log';
		$logHandle = fopen($path,'a');
		$divmode = false;
		$this->loadStrFiles("boot");
		$this->info("\x1b[38;5;83m[SYSTEM]" . "\x1b[38;5;231mテキストファイルの再読み込みがしたい場合は、「reload」と入力してエンターしてください。" . PHP_EOL .
		"\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m気に入った作品があれば、「save」と入力するとsaves.logに保存されます！" . PHP_EOL .
		"\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m終了時は「exit」と入力してください。" . PHP_EOL .
		"\x1b[38;5;214m＝＝＝＝＝＝＝＝＝＝エンターキーで更新＝＝＝＝＝＝＝＝＝\x1b[38;5;231m" . PHP_EOL);
		$a = "";
		while (true) {
			if ($a != "") {
				switch ($a) {
					case 'reload':
						$this->loadStrFiles("reload");
						break;
					case 'save':
						$this->saveStr($mozi);
						break;
					case 'exit':
						$this->addlog("アプリを終了します。");
						goto out;
						break;
					default:
						$this->addlog("\x1b[38;5;83m[SYSTEM]" . "\x1b[38;5;231mテキストファイルの再読み込みがしたい場合は、「reload」と入力してエンターしてください。" . PHP_EOL .
						"\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m気に入った作品があれば、「save」と入力するとsaves.logに保存されます！" . PHP_EOL .
						"\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m終了時は「exit」と入力してください。");
						break;
				}
			}
			$rand1 = rand(0, $this->darega_cnt - 1);
			$rand2 = rand(0, $this->dokode_cnt - 1);
			$rand3 = rand(0, $this->naniwo_cnt - 1);
			$rand4 = rand(0, $this->dousuru_cnt - 1);
			$dare = trim($this->darega[$rand1]);
			$doko = trim($this->dokode[$rand2]);
			$nani = trim($this->naniwo[$rand3]);
			$dou = trim($this->dousuru[$rand4]);
			if ($divmode == True) {
				$this->addlog($rand1 . "," .$rand2 . "," . $rand3 . "," . $rand4 . "\n");
			}
			$mozi = $dare . "が" . $doko .  "で" . $nani . "を" . $dou . PHP_EOL;
			$this->addlog($mozi);
			echo(">");
			$a = trim(fgets(STDIN));
			$pr_time = date('A-H:i:s');
			$prompt = PHP_EOL . "[{$pr_time}]";
			if (isset($logHandle)){
				fwrite($logHandle,"{$prompt} [BOWZU]" . trim($mozi));
			}
		}
		out:
	}

	public function loadStrFiles($tipe){
		if ($tipe == "reload") {
			$this->addlog("\x1b[38;5;83m[SYSTEM]" . "File reloading now..." . PHP_EOL);
		}
		global $poPath;
		// foreach($this->darega as $key => $value){
		// 	if(isset($value)){
		// 		$this->addlog($key);
		// 		if(substr($value,1,1) == "#"){
		// 			// $this->addlog("うっひょわ");
		// 			unset($this->darega[$key]);
		// 			$this->darega = array_values($this->darega);
		// 		}
		// 	}
		// }
		// $this->darega = array_merge($this->darega);
		// // var_dump($this->darega);
		$this->darega_file = trim(file_get_contents($this->dir . "\\" . "darega.txt"));
		$this->darega = explode("\n", $this->darega_file);
		$this->darega_cnt = count($this->darega);
		$first_darega = trim($this->darega[0]);
		$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . "darega.txtを読み込みました。:");
		$this->addlog("\"" . $first_darega . "\"から\"" . $this->darega[$this->darega_cnt - 1] . "\"までの" . $this->darega_cnt . "個の単語。\n");
		$this->dokode_file = trim(file_get_contents($this->dir . "\\" . "dokode.txt"));
		$this->dokode = explode("\n", $this->dokode_file);
		$this->dokode_cnt = count($this->dokode);
		$first_dokode = trim($this->dokode[0]);
		$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . "dokode.txtを読み込みました。:");
		$this->addlog("\"" . $first_dokode . "\"から\"" . $this->dokode[$this->dokode_cnt - 1] . "\"までの" . $this->dokode_cnt . "個の単語。\n");
		$this->naniwo_file = trim(file_get_contents($this->dir . "\\" . "naniwo.txt"));
		$this->naniwo = explode("\n", $this->naniwo_file);
		$this->naniwo_cnt = count($this->naniwo);
		$first_naniwo = trim($this->naniwo[0]);
		$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . "naniwo.txtを読み込みました。:");
		$this->addlog("\"" . $first_naniwo . "\"から\"" . $this->naniwo[$this->naniwo_cnt - 1] . "\"までの" . $this->naniwo_cnt . "個の単語。\n");
		$this->dousuru_file = trim(file_get_contents($this->dir . "\\" . "dousuru.txt"));
		$this->dousuru = explode("\n", $this->dousuru_file);
		$this->dousuru_cnt = count($this->dousuru);
		$first_dousuru = trim($this->dousuru[0]);
		$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . "dousuru.txtを読み込みました。:");
		$this->addlog("\"" . $first_dousuru . "\"から\"" . $this->dousuru[$this->dousuru_cnt - 1] . "\"までの" . $this->dousuru_cnt . "個の単語。\n");
		if ($tipe == "reload") {
			$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . "Reload completed!" . PHP_EOL);
		}
		global $savesHandle;
		$savespath = $this->dir . "/saves.log";
		$savesHandle = fopen($savespath,'a');
		// var_dump($savesHandle);
	}
	public function saveStr($str){
		global $savesHandle;
		global $prompt;
		global $pr_time;
		$pr_time = date('A-H:i:s');
		$prompt = PHP_EOL . "[{$pr_time}]";
		if (isset($savesHandle)){
			fwrite($savesHandle,"{$prompt}" . trim($str));
		}
		$this->addlog("\x1b[38;5;83m[SYSTEM]\x1b[38;5;231m" . trim("「" . trim("{$prompt} {$str}") . "」を保存しました。") . PHP_EOL);
		///ログを吐く
	}

}
