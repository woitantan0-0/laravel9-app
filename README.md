# laravel9-app
laravel9トレーニング用のリポジトリ

環境構築には Docker を使用する

参考：
https://zenn.dev/eguchi244_dev/books/laravel-tutorial-books

## docerコマンド
Docker を起動
```
docker-compose up -d
```

PHPコンテナにログインする
```
docker-compose exec php bash
```

DBコンテナにログインする
```
docker-compose exec db bash
```

コンテナからログアウト
```
exit
```

サービスに関連するコンテナ, イメージ, ボリュームを全て削除する
```
docker-compose down -v --rmi all
```

- 個別に消したい場合には下記のようにします
   ```
   # コンテナ（とネットワーク）削除
   ~ $ docker-compose down
   # コンテナとボリュームの削除
   ~ $ docker-compose down -v
   # コンテナとイメージの削除
   ~ $ docker-compose down --rmi all
   ```
- サービスに限定しないで一括で消す場合
   ```
   # コンテナを停止する
   ~ $ docker-compose stop
   # コンテナの一括削除
   ~ $ docker rm $(docker ps -aq)
   # ネットワークの一括削除
   ~ $ docker network prune
   # イメージの一括削除
   ~ $ docker rmi $(docker images -q)
   # ボリュームの削除
   ~ $ docker volume prune
   ```
   但し、このコマンドはサービスに限定せずに全ての現在実行中および停止中の全ての コンテナ, ネットワーク, イメージ, ボリューム を一括削除します。そのため、実行する際には慎重に行なってください。例えば、何が起きても困らない自分の学習用PC端末などですべて消したい場合で使用します。
- 個別に消したい場合
   ```
   # コンテナを停止する
   ~ $ docker-compose stop
   
   # コンテナを確認する
   ~ $ docker ps -a
   # 特定のコンテナの削除
   ~ $ docker rm コンテナID (CONTAINER ID)
   
   # ネットワークを確認する
   ~ $ docker network ls
   # 特定のネットワークの削除
   ~ $ docker network rm (NETWORK NAME)
   
   # イメージを確認する
   ~ $ docker images
   # 特定のイメージの削除
   ~ $ docker rmi イメージID (IMAGE ID)
   
   # ボリュームを確認する
   ~ $ docker images
   ~ $ docker volume ls
   # 特定のボリュームの削除
   ~ $ docker volume rm (VOLUME NAME)
   ```
