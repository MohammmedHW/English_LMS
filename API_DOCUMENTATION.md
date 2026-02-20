# English Learning LMS - Student API Documentation

This document provides the API endpoints for the Flutter application to interact with the English Learning LMS.

## Base URL
`http://your-domain.com/api`

---

## 1. Authentication

### Student Login
**Endpoint:** `POST /login`  
**Description:** Authenticate a student and receive an API token.

**Request Body:**
```json
{
    "email": "student@example.com",
    "password": "password123"
}
```

**Success Response:**
```json
{
    "status": "success",
    "token": "1|ABC...",
    "user": {
        "id": 1,
        "name": "Jane Doe",
        "email": "student@example.com",
        "role": "student",
        "phone": "1234567890",
        "email_verified_at": null,
        "course_id": null
    }
}
```

### Student Registration
**Endpoint:** `POST /register`  
**Description:** Create a new student account.

**Request Body:**
```json
{
    "name": "Alex Smith",
    "email": "alex@example.com",
    "phone": "9876543210",
    "password": "securepassword"
}
```

**Success Response:**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "token": "2|XYZ...",
    "user": {
        "id": 2,
        "name": "Alex Smith",
        "email": "alex@example.com",
        "phone": "9876543210",
        "role": "student"
    }
}
```

### Logout
**Endpoint:** `POST /logout`  
**Header:** `Authorization: Bearer {token}`
**Description:** Revoke the current token.

---

## 2. Content Structure (Levels -> Courses -> Lessons)

### Get All Levels
**Endpoint:** `GET /levels`  
**Description:** Fetch the 3 predefined levels (Junior, School, College).

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "Junior"
        },
        {
            "id": 2,
            "name": "School"
        },
        {
            "id": 3,
            "name": "College"
        }
    ]
}
```

### Get Courses by Level
**Endpoint:** `GET /courses/{level_id}`  
**Description:** Fetch all courses within a specific level.

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "level_id": 1,
            "title": "Basic English",
            "description": "...",
            "image": "url..."
        }
    ]
}
```

### Get Lessons by Course (with Lock Status)
**Endpoint:** `GET /lessons/{course_id}`  
**Header:** `Authorization: Bearer {token}`  
**Description:** Fetch all lessons within a course. Includes lock status based on user progress.

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "course_id": 1,
            "title": "Alphabet Basics",
            "order": 1,
            "is_unlocked": true,
            "is_completed": true,
            "pass_score": 60
        },
        {
            "id": 2,
            "course_id": 1,
            "title": "Greetings",
            "order": 2,
            "is_unlocked": true,
            "is_completed": false,
            "pass_score": 60
        }
    ]
}
```

---

## 3. Lesson Flow

### A) Practice Mode (Exercises)

#### Get Exercises
**Endpoint:** `GET /lesson/{id}/exercises`  
**Header:** `Authorization: Bearer {token}`  
**Description:** Fetch all practice exercises for a lesson.

**Response Structure (Data):**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "type": "Multiple Choice",
            "question": "What is the capital of France?",
            "options": ["London", "Paris", "Berlin", "Madrid"],
            "answer": "Paris"
        },
        {
            "id": 2,
            "type": "Match the Pair",
            "question": "Match colors with objects",
            "options": [
                {"left": "Red", "right": "Apple"},
                {"left": "Blue", "right": "Sky"},
                {"left": "Green", "right": "Grass"}
            ],
            "answer": "pairs"
        },
        {
            "id": 3,
            "type": "True/False",
            "question": "Water boils at 100 degrees Celsius.",
            "options": null,
            "answer": "True"
        },
        {
            "id": 4,
            "type": "Fill in the Blank",
            "question": "She ___ to school every day.",
            "options": null,
            "answer": "goes"
        }
    ]
}
```

#### Question Types Detail:

| Type | Question Field Usage | Options Structure | Answer Field |
| :--- | :--- | :--- | :--- |
| **Multiple Choice** | The main question. | `["A", "B", "C", "D"]` | The correct string. |
| **True/False** | A statement. | `null` | `"True"` or `"False"`. |
| **Fill in the Blank**| Use `___` for the gap. | `null` | The missing word. |
| **Complete the Sentence** | The start of a sentence. | `["Option A", "Option B"]`| The finishing part. |
| **Match the Pair** | Instructions. | `[{"left": "A", "right": "B"}]` | `"pairs"` (static). |

---

#### Complete Exercises
**Endpoint:** `POST /lesson/{id}/complete-exercises`  
**Header:** `Authorization: Bearer {token}`  
**Description:** Call this when user finishes all practice exercises. Unlocks the Final Test.

**Response:**
```json
{
    "status": "success",
    "message": "Exercises completed. Final test unlocked!"
}
```

### B) Final Test (Locked Mode)

#### Get Test Questions
**Endpoint:** `GET /lesson/{id}/test`  
**Header:** `Authorization: Bearer {token}`  
**Description:** Fetch questions for the final test. Fails if exercises not completed or test is locked.
**Response Structure:** Same as Practice Mode.


#### Submit Test
**Endpoint:** `POST /lesson/{id}/submit-test`  
**Header:** `Authorization: Bearer {token}`  
**Description:** Submit answers for the final test. Returns score and pass status.

**Request Body:**
```json
{
    "answers": {
        "5": "Thinking",
        "6": "True"
    }
}
```
*(Key is Question ID, Value is Answer)*

**Response:**
```json
{
    "status": "success",
    "data": {
        "score": 80,
        "is_passed": true,
        "pass_score": 60,
        "message": "Congratulations! You passed!"
    }
}
```

---

## 4. Student Profile

### Get Profile Details
**Endpoint:** `GET /profile`  
**Header:** `Authorization: Bearer {token}`  

**Response:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Jane Doe",
        "email": "student@example.com",
        "phone": "1234567890",
        "role": "student"
    }
}
```

### Update Profile
**Endpoint:** `PUT /update-profile`  
**Header:** `Authorization: Bearer {token}`  

**Request Body:**
```json
{
    "name": "Jane Updated",
    "phone": "0987654321",
    "password": "optional_new_password" 
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Profile updated successfully"
}
```

---

## 5. Common Error Responses

| Status Code | Description | Example Message |
| :--- | :--- | :--- |
| **401** | Unauthorized | "Unauthenticated." |
| **403** | Forbidden | "You must complete exercises before taking the test." |
| **404** | Not Found | "Course not found." |
| **422** | Unprocessable Entity | "The email has already been taken." |

---

## 6. Question Matching Logic (Flutter Side)

To ensure the Flutter app validates answers correctly, follow these rules:

1.  **Multiple Choice**: Case-sensitive string match between user selection and `answer`.
2.  **True/False**: Match against strings `"True"` or `"False"`.
3.  **Fill in the Blank**: Case-insensitive string match recommended.
4.  **Match the Pair**: The student is correct if they match all `left` items to their corresponding `right` items as provided in the `options` array. (Note: Server currently stores `"pairs"` as the placeholder answer).

---
*Created by AI Developer Assistant — Refined Feb 2026*
