## Консоль
```
make up
docker exec -it project_app bash
php public/index.php <команда>
```
### Команды для консоли
- list
- create <имя> <фамилия> <почта>
- delete \<ID\>

## Web
```
make up
```
<http://0.0.0.0:8080>
### Маршруты
- GET /list-users
- POST /create-user
- DELETE /delete-user/{id}
