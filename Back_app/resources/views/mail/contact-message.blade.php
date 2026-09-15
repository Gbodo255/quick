<x-mail::message>
# Nouveau message de contact

**Nom :** {{ $fromName }}
**E-mail :** {{ $fromEmail }}

---

{{ $messageBody }}

---

Répondez directement à cet e-mail pour contacter {{ $fromName }}.
</x-mail::message>
