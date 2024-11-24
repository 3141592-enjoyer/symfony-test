# Тестовое RestAPI для управления пользователями

## Реализованные функции

* [Просмотр пользователей](#show-all-users)
* [Просмотр пользователя по id](#show-user-by-id)
* [Добавление пользователя](#add-user)
* [Изменение пользователя](#update-user)
* [Удаление пользователя](#delete-user)

***

### Show all users

Вывод всех пользователей 

**Метод:** _GET_ \
**URL:** _/api/users_

**Запрос:** _/api/users_ 

**Ответ:**
```json
[
  {
    "id": 1,
    "name": "testuser",
    "password": "$2y$13$F4KXzWo3cRIwIXB8vx1Gye8wJuhIzSTGxWlPKVd/Xgg9.psWFFKIi"
  },
  {
    "id": 3,
    "name": "user1",
    "password": "$2y$13$QWp3PLkU5MRdJbkgh2F6C.8oRKjxV0kxOzwyiV7F9ozbNGkiJBjwu"
  },
  {
    "id": 4,
    "name": "Vadimka",
    "password": "$2y$13$Sys8L8Ud0yRQhVkUbKewHu1SYr6qS52cCFJGuVaFi6WDxXKf9aBDS"
  },
  {
    "id": 5,
    "name": "AnotherUser",
    "password": "$2y$13$7wY06EiaX1mIs5fN3XvICe/ziU1kvtmnLQdp17Bla0hdkVBUBrhzq"
  },
  {
    "id": 6,
    "name": "UserName",
    "password": "$2y$13$.f.9aC06zvoEEo0rYbxv5u3xBYSvLvKr4sRP2JB302Z4VLRvCz8ym"
  }
]
```

### Show user by-id

Вывод пользователя с конкретным id 

**Метод:** _GET_ \
**URL:** _/api/users/{id}_

**Запрос:** _/api/users/1_ 

**Ответ:**
```json
{
  "id": 1,
  "name": "testuser",
  "password": "$2y$13$F4KXzWo3cRIwIXB8vx1Gye8wJuhIzSTGxWlPKVd/Xgg9.psWFFKIi"
}
```
### Add user

Добавить пользователя 

**Метод:** _POST_ \
**URL** _/api/users/new_ 

**Запрос:** _/api/users/new_
```json
{
  "name": "user",
  "password": "123456"
}
```
**Ответ:**
```json
{
  "message": "User created successfully"
}
```
**Возможные ошибки:** \
**400 BadRequest**: Отсутствие полей name или password, некорректный формат json.

### Update user

Изменить информацию пользователя по id 

**Метод:** _PUT_ \
**URL** _/api/users/edit/{id}_ 

**Запрос:**  _/api/users/edit/1_
```json
{
  "name": "user1",
  "password": "654321"
}
```
**Ответ:**
```json
{
  "message": "User updated successfully"
}
```
**Возможные ошибки:** \
**400 BadRequest**: Некорректный формат json.

### Delete user

Удалить пользователя по id 

**Метод:** _DELETE_ \
**URL:** _/api/users/delete/{id}_ 

**Запрос:** _/api/users/delete/3_ 

**Ответ:**
```json
{
  "message": "User deleted successfully"
}
```
