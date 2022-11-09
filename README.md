# 1行掲示板
PHPとSQLを組み合わせた簡素な1行掲示板です。  
各PHPファイルの変数username, passwordはマスクしてあります。

# DB構造
DB:keijibanには,bbsテーブル, userテーブルがあり  
bbsテーブルには,主キーであるidカラム, 文字列のspeaker, contentカラム,  
datetime型updated_atカラムがあります。  
(コードの順としては,id, content, updated_at, speaker)  
userテーブルには,文字列型のusername, password, nicknameがあります。  
(コードの順としては、上記の通り)  
また,passwordはhash関数でマスクしています。

ログイン管理は、sessionで管理し、30分でセッションタイムアウトするようにしています。
