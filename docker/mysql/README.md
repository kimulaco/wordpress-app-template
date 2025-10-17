# ローカルデータベース

## データベースダンプの使い方

### データベースを復元

```bash
# ダンプファイルから復元
bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz

# 非圧縮ファイルも対応
bash docker/mysql/scripts/restore.sh docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql
```

### 新しいダンプを作成

```bash
bash docker/mysql/scripts/dump.sh
# 出力: docker/mysql/dumps/wordpress-YYYYMMDD_HHMMSS.sql.gz
```

### データベースをリセット

```bash
# データベースを空の状態にリセット
bash docker/mysql/scripts/reset.sh
```

## セキュリティに関する注意

- **絶対に** `.sql` ファイルをGitにコミットしないでください
- ダンプには機密情報（ユーザーデータ、認証情報など）が含まれている可能性があります
- ダンプファイルは安全な経路を通じてのみ共有してください
