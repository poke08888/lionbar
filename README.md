# Lion Bartender

WordPress site (custom theme `lion-bartender`) for lionbartender.com, packaged to run locally with Docker.

## Nội dung

- `wp-content/` — themes (gồm theme tùy biến `lion-bartender`), plugins, uploads, languages.
- `wordpress/custom.ini` — cấu hình PHP (upload limit, memory, timezone).
- `docker-compose.yml` — MySQL 8 + WordPress (php8.4) cho môi trường local.
- `.env.example` — mẫu biến môi trường (copy sang `.env`).

> Lưu ý: **Database KHÔNG nằm trong repo** (dữ liệu, không phải code). Để có nội dung site,
> import một bản dump `lionbartender.sql` vào MySQL container sau khi khởi động.

## Chạy local

```bash
cp .env.example .env      # chỉnh mật khẩu nếu muốn
docker compose up -d
# WordPress: http://localhost:8080
```

### Import database (nếu có file dump)

```bash
docker compose exec -T db \
  mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < lionbartender.sql
```

Sau khi import, vào `wp_options` chỉnh `siteurl` và `home` về `http://localhost:8080`
(hoặc dùng WP-CLI `search-replace`) để chạy đúng trên local.

## Theme

Theme chính: `wp-content/themes/lion-bartender` — custom post type `lb_product`,
taxonomy `lb_scent`, các trang checkout / story / scents.
