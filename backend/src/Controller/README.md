# API Documentation

## Authentication

The API uses JSON Web Tokens (JWT) for authentication. Only /api/register & /api/login_check dont need authentication. To access protected endpoints, you need to include the JWT token in the `Authorization` header of your requests.

### Register a User

**Endpoint:** `/api/register`

**Method:** `POST`

**Request:**
```json
{
  "email": "user@example.com",
  "password": "securepassword"
}
```

### Obtain JWT Token (email -> username)

**Endpoint:** `/api/login_check`

**Method:** `POST`

**Request:**
```json
{
  "username": "user@example.com",
  "password": "securepassword"
}
```

**Response:**
```json
{
  "token": "jwtToken"
}
```

## API endpoint: Courses

### List Courses

**Endpoint:** `/api/courses`

**Method:** `GET`

**Example Request:**
```json
[
  {
    "id": 1,
    "title": "Updated Course",
    "description": "Updated description",
    "quizSets": [
      {
        "id": 1,
        "title": "New QuizSet",
        "description": "Description of the new QuizSet",
        "quizzes": [
          {
            "id": 1,
            "type": "Multiple Choice",
            "question": "New Question",
            "rightAnswer": "New Right Answer",
            "wrongAnswer": "New Wrong Answer"
          },
          {
            "id": 2,
            "type": "Multiple Choice",
            "question": "This is a updated question",
            "rightAnswer": "Updated Answer",
            "wrongAnswer": "Updated Answer"
          }
        ]
      }
    ]
  },
  {
    "id": 2,
    "title": "Second Course",
    "description": "Description of the second course",
    "quizSets": []
  }
]
```

### Create a Course

**Endpoint:** `/api/courses`

**Method:** `POST`

**Example Request:**
```json
{
  "title": "New Course",
  "description": "Description of the new course"
}
```

### Update a Course

**Endpoint:** `/api/courses/{id}`

**Method:** `PUT` or `PATCH`

**Example Request:**
```json
{
  "title": "Updated Course",
  "description": "Updated description"
}
```

### Get a Course

**Endpoint:** `/api/courses/{id}`

**Method:** `GET`

**Example Response:**
```json
{
  "id": 1,
  "title": "Updated Course",
  "description": "Updated description",
  "quizSets": [...]
}
```

### Delete a Course

**Endpoint:** `/api/courses/{id}`

**Method:** `DELETE`

**Response:**
```json
"Deleted a course successfully with id {id}"
```

### Add Quiz Set to a Course

**Endpoint:** `/api/courses/{id}/quizsets`

**Method:** `POST`

**Request:**
```json
{
  "title": "New QuizSet",
  "description": "Description of the new QuizSet"
}
```

### Get Quiz Sets for a Course

**Endpoint:** `/api/courses/{id}/quizsets`

**Method:** `GET`

**Response:**
```json
[
  {
    "id": 1,
    "title": "New QuizSet",
    "description": "Description of the new QuizSet",
    "quizzes": [...]
  }
]
```

## Quiz Sets

### Get a Quiz Set

**Endpoint:** `/api/quizsets/{id}`

**Method:** `GET`

**Response:**
```json
{
  "id": 1,
  "title": "New QuizSet",
  "description": "Description of the new QuizSet",
  "course": "Updated Course",
  "quizzes": [...]
}
```

### Update a Quiz Set

**Endpoint:** `/api/quizsets/{id}`

**Method:** `PUT` or `PATCH`

**Request:**
```json
{
  "title": "Updated QuizSet",
  "description": "Updated description"
}
```

**Response:**
```json
{
  "id": 1,
  "title": "Updated QuizSet",
  "description": "Updated description",
  "course": "Course 1",
  "quizzes": [...]
}
```

### Delete a Quiz Set

**Endpoint:** `/api/quizsets/{id}`

**Method:** `DELETE`

**Response:**
```json
"Deleted a quiz set successfully with id {id}"
```

### Add Quiz to a Quiz Set

**Endpoint:** `/api/quizsets/{id}/add-quiz`

**Method:** `POST`

**Request:**
```json
{
  "type": "TrueOrFalse",
  "question": "New Question",
  "rightAnswer": "New Right Answer",
  "wrongAnswer": "New Wrong Answer"
}
```
**Array requests are also possible:**
```json
{
  "type": "MultipleChoice",
  "question": "New Question",
  "rightAnswer": ["New Right Answer", "Second Right Answer"],
  "wrongAnswer": ["New Wrong Answer", "Second Wrong Answer", "Third Wrong Answer"]
}
```

### Get Quizzes for a Quiz Set

**Endpoint:** `/api/quizsets/{id}/quizzes`

**Method:** `GET`

**Response:**
```json
[
  {
    "id": 1,
    "type": "Multiple Choice",
    "question": "New Question",
    "rightAnswer": "New Right Answer",
    "wrongAnswer": "New Wrong Answer"
  },
  {
    "id": 2,
    "type": "Multiple Choice",
    "question": "New Question",
    "rightAnswer": [
      "New Right Answer",
      "Second Right Answer"
    ],
    "wrongAnswer": [
      "New Wrong Answer",
      "Second Wrong Answer",
      "Third Wrong Answer"
    ]
  }
]
```

## Quizzes

### Create a Quiz (not linked to a Set)

**Endpoint:** `/api/quizzes`

**Method:** `POST`

**Request:**
```json
{
  "type": "DragnDrop",
  "question": "Random Question",
  "rightAnswer": "New Right Answer",
  "wrongAnswer": "New Wrong Answer"
}
```

### List all Quizzes

**Endpoint:** `/api/quizzes`

**Method:** `GET`

**Response:**
```json
[
  {
    "id": 1,
    "type": "Multiple Choice",
    "question": "New Question",
    "rightAnswer": "New Right Answer",
    "wrongAnswer": "New Wrong Answer"
  },
  {
    "id": 2,
    "type": "Multiple Choice",
    "question": "New Question",
    "rightAnswer": [
      "New Right Answer",
      "Second Right Answer"
    ],
    "wrongAnswer": [
      "New Wrong Answer",
      "Second Wrong Answer",
      "Third Wrong Answer"
    ]
  },
  {
    "id": 4,
    "type": "DragnDrop",
    "question": "Random Quiz",
    "rightAnswer": "New Right Answer",
    "wrongAnswer": "New Wrong Answer"
  }
]
```

### Update a Quiz per id

**Endpoint:** `/api/quizzes/{id}`

**Method:** `PUT` or `PATCH`

**Request:**
```json
{
  "id": 2,
  "type": "Multiple Choice",
  "question": "This is a updated question",
  "rightAnswer": "One Right Answer",
  "wrongAnswer": ["New Wrong Answer", "Second Wrong Answer", "Third Wrong Answer"]
}

```

### Get a Quiz

**Endpoint:** `/api/quizzes/{id}`

**Method:** `GET`

**Response:**
```json
{
  "id": 2,
  "type": "Multiple Choice",
  "question": "This is a updated question",
  "rightAnswer": "One Right Answer",
  "wrongAnswer": [
    "New Wrong Answer",
    "Second Wrong Answer",
    "Third Wrong Answer"
  ]
}
```

### Delete a Quiz

**Endpoint:** `/api/quizzes/{id}`

**Method:** `DELETE`

**Response:**
```json
"Deleted a quiz successfully with id {id}"
```

## Note
- Replace `{id}` in the endpoint with the actual ID of the resource.
- Ensure to include the JWT token in the `Authorization` header for endpoints that require authentication.
- Except for `/api/register` & `/api/login_check`, all API endpoints require authentication
