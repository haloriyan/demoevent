Build a WhatsApp Web JS gateway server. This is an HTTP API server that wraps
whatsapp-web.js (or Baileys) to manage multiple WhatsApp sessions and expose
a simple REST API. It is consumed by a Laravel app.

---

## Tech Stack
- Runtime: Node.js
- Library: whatsapp-web.js (preferred) or Baileys
- Framework: Express.js
- Session persistence: LocalAuth strategy (one folder per client_id)
- Language: JavaScript (CommonJS or ESM, your choice as long as it flexible with any packages)

---

## Endpoints to implement

### POST /connect
Start a new WhatsApp session and generate a QR code for scanning.

Request body:
{
  "callback_url": "https://caller-app.com/api/callback/wa"
}

Behavior:
- Generate a unique client_id (e.g. UUID)
- Initialize a new whatsapp-web.js Client with LocalAuth keyed to client_id
- Emit a QR code image (as a PNG URL served by this server, e.g. GET /qr-image/{client_id}.png)
- Return immediately:
  {
    "client_id": "uuid",
    "qr_url": "http://this-server/qr-image/{client_id}.png"
  }
- After the user scans and the session is authenticated ("ready" event), fire a
  POST to callback_url with body:
  {
    "client_id": "uuid",
    "name": "WhatsApp display name",
    "number": "628xxxxxxxxxx",
    "profile_picture": "https://..."
  }

### GET /qr/{client_id}
Return the latest QR for a session (polling fallback).

Response:
{
  "qr": "data:image/png;base64,..." or image URL
}

### POST /send
Send a WhatsApp message. Support both text-only and text+image.

Request body (text only):
{
  "client_id": "uuid",
  "destination": "628xxxxxxxxxx",   // also accept "number" as alias
  "message": "Hello world"
}

Request body (with image):
{
  "client_id": "uuid",
  "destination": "628xxxxxxxxxx",
  "image": "https://external-url.com/image.png",   // fetch and send as media
  "message": "Caption text"
}

Behavior:
- Look up the active Client by client_id
- Format number to WhatsApp chat ID: destination + "@c.us"
- If image is present, download it and send as MessageMedia with caption
- If only message, send as plain text
- Return: { "ok": true } or { "ok": false, "error": "..." }

### POST /disconnect
Destroy and remove a session.

Request body:
{
  "client_id": "uuid"
}

Behavior:
- Call client.destroy() on the session
- Remove its LocalAuth data folder
- Return: { "ok": true }

---

## Session management
- Keep an in-memory Map of client_id → Client instance
- On server start, restore any persisted LocalAuth sessions automatically
  and mark them as ready in the map
- Handle "disconnected" event to clean up the map entry

---

## QR image serving
- On each "qr" event from whatsapp-web.js, convert the QR string to a PNG
  using the `qrcode` npm package and save to /tmp/qr-{client_id}.png
- Serve it at GET /qr-image/{client_id}.png as image/png

---

## Error handling
- If client_id is not found in the map, return HTTP 404 { "error": "client not found" }
- Wrap all send operations in try/catch and return 500 on failure

---

## Callback (gateway → app)
After QR scan success, the gateway fires:
  POST {callback_url}
  Body: {
    "client_id": "uuid",
    "name": "WhatsApp display name",
    "number": "628xxxxxxxxxx",
    "profile_picture": "https://..."
  }
The app stores this device record and uses client_id for all future /send calls.

---

## Project structure
gateway/
  index.js          ← Express app + route handlers
  sessions.js       ← Map + session lifecycle helpers
  package.json

---

## package.json dependencies
- express
- whatsapp-web.js
- qrcode
- uuid
- axios (for firing callback_url)
- puppeteer (peer dep for whatsapp-web.js)
