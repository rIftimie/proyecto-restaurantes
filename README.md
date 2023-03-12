# Restaurant Chain: Nacho's Guacamole

## Project Structure

| Grupo 1  | Grupo 2 | Grupo 3 |
| -------- | ------- | ------- |
| Mario    | Robert  | Romen   |
| Josemi   | Pablo   | Comino  |
| Romen2   | Ivan    | Jose    |
| Daulin   | Israel  | Fran    |
| Jorge    | Jose    | Hugo    |
| Jonathan | Antonio | Juanto  |
| Chema    | Juan    | Alvaro  |
| Rafa     |         |         |

## Real Time Notifications with Mercure Protocol

localhost:3000

`sudo setcap cap_net_bind_service=+ep literal_path_to_binary`

`MERCURE_PUBLISHER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!' MERCURE_SUBSCRIBER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!' ./bin/mercure run --config Caddyfile.dev`

Iniciarlo en windows
$env:MERCURE_PUBLISHER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; $env:MERCURE_SUBSCRIBER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; .\bin\mercure.exe run --config Caddyfile.dev
