FROM mysql:9.3

# カスタム設定ファイルを同じディレクトリからコピーし、適切な権限を設定
COPY --chown=mysql:mysql --chmod=644 ./my.cnf /etc/mysql/conf.d/my.cnf
