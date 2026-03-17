# Rooms API Documentation

## Overview

The Rooms API manages all hotel rooms across 7 floors. The hotel has 41 rooms in total, ranging from standard rooms on lower floors to penthouse suites on the top floor.

### Hotel Structure

| Floor | Type | Rooms | Price Range |
|-------|------|-------|-------------|
| 1 | Standard | 101–105 (5 rooms) | $75–$100/night |
| 2 | Standard | 201–206 (6 rooms) | $75–$100/night |
| 3 | Superior | 301–306 (6 rooms) | $120–$160/night |
| 4 | Superior | 401–406 (6 rooms) | $120–$160/night |
| 5 | Deluxe | 501–506 (6 rooms) | $180–$250/night |
| 6 | Junior Suite | 601–605 (5 rooms) | $300–$380/night |
| 7 | Penthouse | 701–707 (7 rooms) | $400–$600/night |

---

## Room Types

| Type | Description |
|------|-------------|
| `standard` | Comfortable rooms with essential amenities. Floors 1–2. |
| `superior` | Upgraded rooms with additional comfort. Floors 3–4. |
| `deluxe` | Premium rooms with enhanced amenities and better views. Floor 5. |
| `junior_suite` | Spacious suites with separate living area. Floor 6. |
| `penthouse` | Top-floor luxury suites with panoramic views and premium amenities. Floor 7. |

> Legacy types also supported: `single`, `double`, `suite`, `apartment`

---

## Endpoints

### GET /api/rooms

Returns a paginated list of all rooms.

**Query Parameters**

| Parameter | Type | Description |
|-----------|------|-------------|
| `type` | string | Filter by room type (e.g. `penthouse`) |
| `floor` | integer | Filter by floor number (e.g. `7`) |
| `available` | boolean | Filter by availability (`true` / `false`) |
| `guests` | integer | Filter rooms with capacity >= value |
| `max_price` | number | Filter rooms with price <= value |
| `page` | integer | Page number (default: 1) |

**Response 200**
```json
{
  "data": [
    {
      "id": 1,
      "name": "701",
      "type": "penthouse",
      "description": "Luxury top-floor suite with panoramic city views.",
      "price_per_night": 500.00,
      "capacity": 4,
      "floor": 7,
      "is_available": true,
      "amenities": ["WiFi", "TV", "Jacuzzi", "Mini bar", "Butler service"],
      "images": [
        "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800",
        "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800",
        "https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800"
      ],
      "created_at": "2026-01-01 00:00:00",
      "updated_at": "2026-01-01 00:00:00"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": null },
  "meta": { "current_page": 1, "per_page": 15, "total": 41 }
}
```

---

### GET /api/rooms/{id}

Returns a single room by ID.

**Response 200** — same structure as a single item in the list above.

**Response 404**
```json
{ "message": "No query results for model [App\\Models\\Room]." }
```

---

### POST /api/rooms

Creates a new room.

**Request Body**

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| `name` | string | yes | max:255, unique |
| `type` | string | yes | one of the valid types |
| `description` | string | no | — |
| `price_per_night` | number | yes | min:0 |
| `capacity` | integer | yes | min:1, max:20 |
| `floor` | integer | no | min:0 |
| `is_available` | boolean | no | — |
| `amenities` | array | no | array of strings |
| `images` | array | no | max 3 URLs |

**Response 201** — created room object wrapped in `data`.

**Response 422**
```json
{
  "message": "The name field is required.",
  "errors": {
    "name": ["Room name is required."],
    "type": ["Room type is required."]
  }
}
```

---

### PUT/PATCH /api/rooms/{id}

Updates an existing room. Use `PATCH` for partial updates (only send fields you want to change).

**Request Body** — same fields as POST, all optional with `PATCH`.

**Response 200** — updated room object wrapped in `data`.

**Response 404** — room not found.

**Response 422** — validation errors.

---

### DELETE /api/rooms/{id}

Soft-deletes a room (sets `deleted_at`, does not remove from database).

**Response 200**
```json
{ "message": "Room deleted successfully." }
```

**Response 404** — room not found.

---

## Fields Reference

### `images`
An array of up to 3 image URLs per room. Images are hosted on Unsplash CDN.

- Floors 1–5: generic hotel room photos
- Floors 6–7: unique luxury/suite photos (each room has distinct images)

Append `?w=800` for optimized 800px width. Example:
```
https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800
```

### `amenities`
A JSON array of strings describing room features.

Examples by floor level:
- Standard: `["WiFi", "TV", "Air conditioning", "Safe"]`
- Superior: `["WiFi", "TV", "Air conditioning", "Mini bar", "Safe", "Balcony"]`
- Deluxe: `["WiFi", "TV", "Air conditioning", "Mini bar", "Safe", "Balcony", "Bathrobe"]`
- Junior Suite: `["WiFi", "TV", "Air conditioning", "Jacuzzi", "Mini bar", "Kitchen", "Safe"]`
- Penthouse: `["WiFi", "TV", "Air conditioning", "Jacuzzi", "Mini bar", "Kitchen", "Butler service", "Private terrace", "Safe"]`
