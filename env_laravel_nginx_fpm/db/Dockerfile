# db/Dockerfile
FROM mysql:9.3

# 設定ファイルをコピー (Dockerfileと同じディレクトリから、所有者指定)
COPY --chown=mysql:mysql ./my.cnf /etc/mysql/conf.d/my.cnf
