- docker-compose.yml内での環境変数参照
```
  db:
    image: mysql:8.0
    container_name: larasocket-db
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: ${MYSQL_DATABASE}
      MYSQL_USER: ${MYSQL_USER}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      TZ: 'Asia/Tokyo'
    volumes:
      - ./db/data:/var/lib/mysql
      - ./db/my.cnf:/etc/mysql/conf.d/my.cnf
      - ./logs/mysql/:/var/log/mysql/
    ports:
      - 3306:3306
```