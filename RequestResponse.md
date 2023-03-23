# 1. Авторизация и аутентификация

_Во всех запросах должен присутствовать header_

[

    Key: "X-Requested-With"

    Value: "XMLHttpRequest"

]


## Регистрация

### Точка Входа

- Точка входа для регистрации: **/api/register**

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

  "message": "Success"

  }
- 
- Код ответа: 200

- Cookies

        [
    
        name: 'access_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

        [

        name: 'refresh_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

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

- Метод: **POST**

- Схема:

  {

  **email: string**

  **password: string**

  }

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }
- Код ответа: 200
- Cookies

        [
    
        name: 'access_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

        [

        name: 'refresh_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

#### Неудача

- Схема:

  {

  "error": "Unauthorized"

  }

- Код ответа: 401


## Получение пользователя по токену

### Точка Входа

- Точка входа для регистрации: **/api/me**

### Запрос

- Метод: **POST**

- BearerToken "token"

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "name": "user",

  "email": "test@test.ru",

  "created_at": "2023-03-07T18:46:57.000000Z",

  "updated_at": "2023-03-07T18:46:57.000000Z"

  }
- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Unauthenticated."

  }

- Код ответа: 401

## Обновление токена

### Точка Входа

- Точка входа для регистрации: **/api/refresh**

### Запрос

- Метод: **POST**

- BearerToken "token"

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }
- Код ответа: 200

- Cookies

       [
    
        name: 'access_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

        [

        name: 'refresh_token'
    
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjU1NTUvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjc4MzYzNTQ1LCJleHAiOjE2NzgzNjM2MDUsIm5iZiI6MTY3ODM2MzU0NSwianRpIjoib09HS2pxamxCbnFDZWw2TyIsInN1YiI6IjgiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.cG7nSAWAaWAh_jDkBnZupu71HQp8gkt2YNt9N3-mQ3Q'
        
        ]

#### Неудача

- Схема:

  {

  "message": "The token has been blacklisted"

    ...

  }

- Код ответа: 500


## Выход

### Точка Входа

- Точка входа для регистрации: **/api/logout**

### Запрос

- Метод: **POST**

- BearerToken "token"

### Ответ

#### Успех

- Схема:

  {

  "message": "Successfully logged out"

  }
- Код ответа: 200


#### Неудача

- Схема:

  {

  "message": "Unauthenticated."

  }

- Код ответа: 401


# 2. Курсы

## Получение списка всех курсов

### Точка Входа

- Точка входа для регистрации: **/api/courses**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "id": 1,

  "course_name": "Business Manager",

  "description": "Voluptate nam distinctio voluptas optio necessitatibus doloremque odio. Totam cumque eum et possimus. Odit alias debitis illum qui qui eligendi. Dolor consequuntur quis consectetur dignissimos velit enim est.",
  
  "tag": "Quia molestiae.",

  "cover_url": "http://lindgren.com/",

  "author": "Dr. Clyde Heaney V",

  "start_date": "22-04-2011",

  "end_date": "28-06-2010",

  "course_program": 

        {

        "heading": "Night Security Guard",

        "description": "Aliquam tempora voluptatem velit sequi qui autem voluptate. At quia ab eligendi aut doloremque quo fugit optio. Eligendi aspernatur suscipit doloribus est."
        
        },

  "created_at": "2023-03-16T16:29:53.000000Z",

  "updated_at": "2023-03-16T16:29:53.000000Z"

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

  "course_name": "Business Manager",

  "description": "Voluptate nam distinctio voluptas optio necessitatibus doloremque odio. Totam cumque eum et possimus. Odit alias debitis illum qui qui eligendi. Dolor consequuntur quis consectetur dignissimos velit enim est.",
  
  "tag": "Quia molestiae.",

  "cover_url": "http://lindgren.com/",

  "author": "Dr. Clyde Heaney V",

  "start_date": "22-04-2011",

  "end_date": "28-06-2010",

  "course_program": 

        {

        "heading": "Night Security Guard",

        "description": "Aliquam tempora voluptatem velit sequi qui autem voluptate. At quia ab eligendi aut doloremque quo fugit optio. Eligendi aspernatur suscipit doloribus est."
  
        },

  "created_at": "2023-03-16T16:29:53.000000Z",

  "updated_at": "2023-03-16T16:29:53.000000Z"

  },

- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Такого курса не существует"

  }

- Код ответа: 404


## Создание курса

### Точка Входа

- Точка входа для регистрации: **/api/courses/{id}**

### Запрос

- Метод: **POST**

- BearerToken "token"

- Схема:

{

"course_name": "php",

"description": "Краткое описание курса",

"tag": "php",

"cover_url": "http://vandervort.biz/adipisci-ut-doloremque-non-asperiores-rerum-eos",

"start_date": "2023-12-09",

"end_date": "2023-12-09",

"course program": 

    {

    "heading": "php",

    "description": "Краткое описание курса"

    }

}

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }

- Код ответа: 200

#### Неудача

В случае если пользователь не авторизован

- Схема:

  {

  "message": "Курс может составлять только авторизованный пользователь"

  }

- Код ответа: 401

В остальных случаях

- Схема:

  {

  "message": "Error"

  }

- Код ответа: 400


## Создание контента для заданного курса

### Точка Входа

- Точка входа для регистрации: **/api/courses/{id}/content**

### Запрос

- Метод: **PATCH**

- BearerToken "token"

- Схема:

{

"content": "Проверка in aut ipsa velit sed et. Unde in temporibus magni. Rem rerum eius ut repellat quaerat sed. Quos atque velit similique deserunt beatae qui maiores. Autem accusantium unde perspiciatis quasi non cumque sapiente. Qui molestiae impedit fuga voluptatum eum quia. Quam in impedit doloremque qui rerum inventore quis. Debitis animi esse проверка."

}

### Ответ

#### Успех

- Схема:

  {

  "message": "Success"

  }

- Код ответа: 200

#### Неудача

В случае если пользователь не авторизован

- Схема:

  {

  "message": "Содержание курса может создавать только авторизованый пользователь"

  }

- Код ответа: 401

В случае если контент пытается создать не автор курса

- Схема:

  {

  "message": "Содержание курса может создавать только автор курса"

  }

- Код ответа: 401

В остальных случаях

- Схема:

  {

  "message": "Error"

  }

- Код ответа: 400


## Страница контента заданного курса

### Точка Входа

- Точка входа для регистрации: **/api/courses/{id}/content**

### Запрос

- Метод: **GET**

### Ответ

#### Успех

- Схема:

  {

  "content": "Ea in aut ipsa velit sed et. Unde in temporibus magni. Rem rerum eius ut repellat quaerat sed. Quos atque velit similique deserunt beatae qui maiores. Autem accusantium unde perspiciatis quasi non cumque sapiente. Qui molestiae impedit fuga voluptatum eum quia. Quam in impedit doloremque qui rerum inventore quis. Debitis animi esse iusto."

  }
- 
- Код ответа: 200

#### Неудача

- Схема:

  {

  "message": "Отсутсвует содержимое курса"

  }

- Код ответа: 404

