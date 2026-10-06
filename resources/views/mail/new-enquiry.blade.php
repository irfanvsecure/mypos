New enquiry from the myPOS website

Name:     {{ $lead->name }}
Business: {{ $lead->business ?: '-' }}
Phone:    {{ $lead->phone }}
Email:    {{ $lead->email ?: '-' }}
Type:     {{ $lead->type ?: '-' }}
Page:     /{{ ltrim($lead->page, '/') }}

Message:
{{ $lead->message ?: '-' }}

WhatsApp: https://wa.me/{{ preg_replace('/\D/', '', preg_replace('/^0/', '92', $lead->phone)) }}
Received: {{ $lead->created_at }}
