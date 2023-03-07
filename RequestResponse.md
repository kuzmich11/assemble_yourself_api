## Регистрация

### Точка Входа

- Точка входа для регистрации: **/api/registration**

### Запрос

- Метод: **POST**

- Схема:

    {

    **name: string**

    **email: string**

    **password: string**

    }

### Ответ

#### Успех

- Схема:

  {

  "message": "Пользователь успешно зарегистрирован"

  }
- Код ответа: 201

#### Неудача

Вариант 1 (если пользователь с данным email уже существует).

- Схема:

  {

  "error": true,

  "message": "Пользователь с данным email уже существует"

  }

- Код ответа: 400

Вариант 2 (любые другие причины)

- Схема:

  {

  "error": true,

  "message": "Не удалось зарегистрировать пользователя"

  }

- Код ответа: 400


## Авторизация

### Точка Входа

- Точка входа для регистрации: **/api/login**

### Запрос

- Метод: **GET**

- Схема:

  {

  **email: string**

  **password: string**

  }

### Ответ

#### Успех

- Схема:

  {

    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL2xvZ2luIiwiaWF0IjoxNjc3ODY4MjA5LCJleHAiOjE2Nzc5NTQ2MDksIm5iZiI6MTY3Nzg2ODIwOSwianRpIjoiQTQ3aUJDU01BcGJGU3JDQiIsInN1YiI6IjEyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.hxuat7G-BmwB9Xn-shz39nO-ZUEbdx-VKY0kouL6b9s"

  }
- Код ответа: 200

#### Неудача

- Схема:

  {

  "error": true,

  "message": "Не верный email или password"

  }

- Код ответа: 401


## Список всех курсов

### Точка Входа

- Точка входа для регистрации: **/api/courses**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "course_name": "Psychiatrist",

  "author": "Dr. Alford Stiedemann MD",

  "price": "476",

  "created_at": "2023-03-02T16:39:18.000000Z",

  "updated_at": "2023-03-02T16:39:18.000000Z"

  }, ...

- Код ответа: 200

Если в базе нет записей курсов, то вернется пустой json с кодом 200.

#### Неудача

(Только в случае если база не доступна)

- Код ответа: 500


## Страница нужного курса

### Точка Входа

- Точка входа для регистрации: **/api/courses/{id}**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "course_name": "Psychiatrist",

  "author": "Dr. Alford Stiedemann MD",

  "price": "476",

  "created_at": "2023-03-02T16:39:18.000000Z",

  "updated_at": "2023-03-02T16:39:18.000000Z"

  }
- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Такого курса не существует"

  }

- Код ответа: 404

В случае если база не доступна

- Код ответа: 500
