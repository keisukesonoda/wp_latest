<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'dev_latest');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'root');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uKXftD@xITvFw=?{-,@:j$ 2ixmyxDYEo9*N|r~,1m}blT R{ql%C:xN@^Gqtj7N');
define('SECURE_AUTH_KEY',  'D7tRu2gh1$*V:L%PmZ-NZy5+L%lBprY&@xiq90zvE6+J+8EG~7_i<Kv;*N(1}/}(');
define('LOGGED_IN_KEY',    '*YoPwBqaZnFG*{5@[}osokgr`nR>UYxwd%^Rv-OOl<Z(CjX=r!SR!c#/BrC>g+;d');
define('NONCE_KEY',        '0Q(cO;HGNh?{k<!WtB/ |MT6/lJ(jU;CB **KCHV>rN9CyWTQ]p%8F^2Me+P!@lR');
define('AUTH_SALT',        'N:gKYoD1 (|tIJ~SXAb5I#Yd#y/7w3@f!kjJ8#sA2b]zSJQC)d502K80iv]18P0A');
define('SECURE_AUTH_SALT', 'N^~:opWU8tNRm%dd9/>0&Hm6OzHpIP+R<0 :)T`FFo&vywan~C^{Tutb:Ji>ad;A');
define('LOGGED_IN_SALT',   'lp.~86vc&0).*e-=wKUr}/xnFu75Y/e5h$]]g4S=CI-a,Nx]OZ3*_*.&IIibNe`H');
define('NONCE_SALT',       'F]:fcztFjWJE}pJhs~OJnt9aT`7KEj4@EeX]O!6bAV7m1yQj?UA;UHiX*X@/ka]j');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
// define('WP_DEBUG', false);
define('WP_DEBUG', true);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
