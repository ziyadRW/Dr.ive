# Dr.ive 📂
A Laravel-based application providing a highly scalable **File Storage System** with support for storing files in **Local Storage**, **Amazon S3**, or **Database Storage**.

This application allows developers to **upload, retrieve, and manage files** via a unified API interface, making it easy to integrate with various storage solutions.

---

## 📌 Project Description
Dr.ive provides a flexible and modular architecture to store and retrieve files. Files can be stored in:

- **Local Storage:** Using Laravel's built-in storage system.
- **Amazon S3:** For scalable and distributed cloud storage.
- **Database Storage:** For saving files as Base64 encoded strings directly in the database.

The application utilizes a **Service Factory Pattern** to dynamically switch between storage types based on the configuration or request.

---

## ⚙️ Configuration

```env
# Default Storage
FILESYSTEM_DISK=local
STORAGE_BACKEND=s3

# AWS S3 Configuration (Optional)
AWS_ACCESS_KEY_ID=YOUR_AWS_ACCESS_KEY
AWS_SECRET_ACCESS_KEY=YOUR_AWS_SECRET_KEY
AWS_DEFAULT_REGION=YOUR_AWS_REGION
AWS_BUCKET=YOUR_AWS_BUCKET
AWS_USE_PATH_STYLE_ENDPOINT=false
```

---

## 📌 API Endpoints

### Store Data (File or Text)

**POST** `/api/v1/Dr.ive/store`

#### Request Parameters:
- `unique_identifier` (string, required): A unique identifier for the file.
- `storage` (string, optional): The storage type (`local`, `s3`, or `database`). Defaults to the `STORAGE_BACKEND` in your `.env`.
- `file` (file, optional): The file to be stored.
- `data` (string, optional): Base64 encoded data (used if no file is uploaded).

#### Example Request (File Upload)
```bash
POST /api/v1/Dr.ive/store
Content-Type: multipart/form-data

{
  "unique_identifier": "example-file",
  "file": "<file>"
}
```

#### Example Request (Base64 Data)
```bash
POST /api/v1/Dr.ive/store
Content-Type: application/json

{
  "unique_identifier": "example-text",
  "data": "SGVsbG8gd29ybGQ="
}
```

---

### Retrieve Data

**GET** `/api/v1/Dr.ive/show/{unique_identifier}`

#### Response:
- `id`: The unique identifier of the stored file.
- `size`: The size of the stored file.
- `created_at`: The date and time of storage.
- `data_type`: Indicates whether the response contains text or file.
- `data`: The Base64 encoded data if it's text.
- `filename`: The file name if it's a file.
- `filetype`: The MIME type of the file if it's a file.

#### Example Response (Text Data)
```json
{
  "id": "example-text",
  "size": 11,
  "created_at": "2025-03-26 12:00:00",
  "data_type": "text",
  "data": "Hello world"
}
```

#### Example Response (File Data)
```json
{
  "id": "example-file",
  "size": 20480,
  "created_at": "2025-03-26 12:00:00",
  "data_type": "file",
  "filename": "example.pdf",
  "filetype": "application/pdf",
  "data": "BASE64_ENCODED_FILE_CONTENT"
}
