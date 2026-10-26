# Database-relaties

- `users` 1-op-veel `jobs`: een werkgever plaatst meerdere vacatures.
- `users` 1-op-veel `applications`: een student verstuurt meerdere sollicitaties.
- `jobs` 1-op-veel `applications`: een vacature ontvangt meerdere sollicitaties.
- `users` veel-op-veel `jobs` via `saved_jobs`: studenten bewaren vacatures.
- `users` 1-op-veel `transactions`: elke financiële transactie hoort bij één gebruiker.

De foreign keys in `database/cashjob.sql` bewaken de relaties. Unieke sleutels voorkomen dubbele sollicitaties op dezelfde vacature en dubbele favorieten.
