# ローカルデータベース

## データベースダンプの使い方

### 実行方法

データベーススクリプトは**CLIコンテナ内**で実行されます。

**DevContainer内から**（推奨）:
```bash
# すでにCLIコンテナ内にいるので、直接実行
bash docker/mysql/scripts/dump.sh
bash docker/mysql/scripts/restore.sh <ファイル>
bash docker/mysql/scripts/reset.sh
```

**ホストマシンから**:
```bash
# CLIコンテナ経由で実行
docker-compose exec cli bash docker/mysql/scripts/dump.sh
docker-compose exec cli bash docker/mysql/scripts/restore.sh <ファイル>
docker-compose exec cli bash docker/mysql/scripts/reset.sh
```

### データベースを復元

```bash
# DevContainer内
bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz

# 非圧縮ファイル(.sql)も対応
```

### 新しいダンプを作成

```bash
# DevContainer内
bash docker/mysql/scripts/dump.sh

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/dump.sh

# 出力: docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz
```

### データベースをリセット

```bash
# DevContainer内
bash docker/mysql/scripts/reset.sh

# ホストマシンから
docker-compose exec cli bash docker/mysql/scripts/reset.sh

# ⚠️ 全データが削除されます
```

## セキュリティに関する注意

- **絶対に** `.sql` ファイルをGitにコミットしないでください
- ダンプには機密情報（ユーザーデータ、認証情報など）が含まれている可能性があります
- ダンプファイルは安全な経路を通じてのみ共有してください
