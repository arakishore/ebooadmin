# Contact Enquiries API Postman Examples

Endpoint:

```text
POST {{base_url}}/api/contact-enquiries
Content-Type: application/json
```

## Contact Enquiry

```json
{
  "enquiry_type": "contact",
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "+91 9876543210",
  "subject": "Trip planning help",
  "message": "I would like help planning a family holiday.",
  "page_url": "https://example.com/contact",
  "referrer_url": "https://google.com",
  "utm_source": "google",
  "utm_medium": "organic",
  "utm_campaign": "summer-travel"
}
```

## Package Enquiry

```json
{
  "enquiry_type": "package",
  "package_id": 1,
  "name": "John Smith",
  "email": "john@example.com",
  "phone": "+1 555 123 4567",
  "subject": "Dubai package enquiry",
  "message": "Please share availability and pricing for this package.",
  "travel_date": "2026-08-15",
  "adults": 2,
  "children": 1,
  "page_url": "https://example.com/packages/dubai-honeymoon-package",
  "referrer_url": "https://example.com/packages",
  "utm_source": "newsletter",
  "utm_medium": "email",
  "utm_campaign": "august-deals"
}
```
