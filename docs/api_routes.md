# TvShow

| Routes                      | Nom de la route     | Méthodes (HTTP) | Controller                          | ->méthode() |
| --------------------------- | ------------------- | --------------- | ----------------------------------- | ----------- |
| /api/v1/tvshows             | api_tvshows_list    | GET             | App\Controller\Api\TvShowController | list        |
| /api/v1/tvshows             | api_tvshows_add     | POST            | App\Controller\Api\TvShowController | add         |
| /api/v1/tvshows/{id}        | api_tvshows_details | GET             | App\Controller\Api\TvShowController | details     |
| /api/v1/tvshows/{id}        | api_tvshows_update  | PUT/PATCh       | App\Controller\Api\TvShowController | update      |
| /api/v1/tvshows/{id}        | api_tvshows_delete  | DELETE          | App\Controller\Api\TvShowController | delete      |
| --------------------------- | ------------------- | --------------- | ----------------------------------- | ----------- |

# Category

| Routes                      | Nom de la route        | Méthodes (HTTP) | Controller                            | ->méthode() |
| --------------------------- | ---------------------- | --------------- | ------------------------------------- | ----------- |
| /api/v1/categories          | api_categories_list    | GET             | App\Controller\Api\CategoryController | list        |
| /api/v1/categories          | api_categories_add     | POST            | App\Controller\Api\CategoryController | add         |
| /api/v1/categories/{id}     | api_categories_details | GET             | App\Controller\Api\CategoryController | details     |
| /api/v1/categories/{id}     | api_categories_update  | PUT/PATCH       | App\Controller\Api\CategoryController | update      |
| /api/v1/categories/{id}     | api_categories_delete  | DELETE          | App\Controller\Api\CategoryController | delete      |
| --------------------------- | -------------------    | --------------- | -----------------------------------   | ----------- |

# Character

| Routes                      | Nom de la route        | Méthodes (HTTP) | Controller                             | ->méthode() |
| --------------------------- | ---------------------- | --------------- | -------------------------------------- | ----------- |
| /api/v1/characters          | api_characters_list    | GET             | App\Controller\Api\CharacterController | list        |
| /api/v1/characters          | api_characters_add     | POST            | App\Controller\Api\CharacterController | add         |
| /api/v1/characters/{id}     | api_characters_details | GET             | App\Controller\Api\CharacterController | details     |
| /api/v1/characters/{id}     | api_characters_update  | PUT/PATCH       | App\Controller\Api\CharacterController | update      |
| /api/v1/characters/{id}     | api_characters_delete  | DELETE          | App\Controller\Api\CharacterController | delete      |
| --------------------------- | -------------------    | --------------- | -----------------------------------    | ----------- |
