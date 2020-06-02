---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#API token


<!-- START_e19414bb8ca64ad4ee4c4cc63da349c4 -->
## Renew tokena
Funkcia obnovi token a vrati novy token &lt;br&gt;
Status kody: &lt;br&gt;
420 - neplatny token &lt;br&gt;
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"inventore"}'

```

```javascript
const url = new URL(
    "http://localhost/api/token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "inventore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/token`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API Token usera
    
<!-- END_e19414bb8ca64ad4ee4c4cc63da349c4 -->

#Cloud


<!-- START_37a7c05f0326d5dddf781950108e3a95 -->
## Ziskaj priecinky
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
200 - ok&lt;br&gt;

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/folders" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"repellat","path":"et"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/folders"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "repellat",
    "path": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/folders`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza default /
    
<!-- END_37a7c05f0326d5dddf781950108e3a95 -->

<!-- START_16e69251dca2530f4e602ebbb1111b18 -->
## Ziskaj subory
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
200 - ok&lt;br&gt;

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/files" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"aliquam","path":"rem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/files"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "aliquam",
    "path": "rem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/files`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza default /
    
<!-- END_16e69251dca2530f4e602ebbb1111b18 -->

<!-- START_46106adab8574ab1eb11be2a01c8f81d -->
## Vytvor priecinok
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
421 - Nezadali ste meno&lt;br&gt;
422 - nepodarilo sa vytvorit subor&lt;br&gt;
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/folders/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"tempora","path":"voluptate","name":"aspernatur"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/folders/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "tempora",
    "path": "voluptate",
    "name": "aspernatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/folders/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza.
        `name` | string |  required  | Nazov priecinka
    
<!-- END_46106adab8574ab1eb11be2a01c8f81d -->

<!-- START_5489ba8aa59201eca72640dd9530cf8e -->
## Odstran priecinok

Status kody:<br>
420 - neplatny token<br>
421 - Nezadali ste meno<br>
422 - nepodarilo sa vymazat subor<br>
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/folders/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"voluptatum","path":"aliquid","name":"explicabo"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/folders/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "voluptatum",
    "path": "aliquid",
    "name": "explicabo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/folders/delete`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza.
        `name` | string |  required  | Nazov priecinka
    
<!-- END_5489ba8aa59201eca72640dd9530cf8e -->

<!-- START_7e4ce5a9e07ac59cad985356337839cc -->
## Pridaj subor

Status kody:<br>
420 - neplatny token<br>
421 - Nezadali ste meno<br>
422 - nepodarilo sa vytvorit subor<br>
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/files/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"quas","path":"ab","subor":"voluptate"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/files/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "quas",
    "path": "ab",
    "subor": "voluptate"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/files/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza
        `subor` | file |  required  | Subor
    
<!-- END_7e4ce5a9e07ac59cad985356337839cc -->

<!-- START_a2a50e865e8fb0fa14f61cd2e97dea88 -->
## Zmaz subor

Status kody: <br>
420 - neplatny token <br>
421 - Nezadali ste meno <br>
422 - Nepodarilo sa vymazat subor <br>
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/files/delete" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"voluptatem","path":"consequuntur","subor":"ea"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/files/delete"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "voluptatem",
    "path": "consequuntur",
    "subor": "ea"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/files/delete`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza
        `subor` | file |  required  | Subor
    
<!-- END_a2a50e865e8fb0fa14f61cd2e97dea88 -->

<!-- START_987bd0ea20cc84f61f20320ddc6bded8 -->
## Stiahni subor
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
421 - Nezadali ste meno&lt;br&gt;

> Example request:

```bash
curl -X POST \
    "http://localhost/api/cloud/files/download" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"molestiae","path":"quia","subor":"sunt"}'

```

```javascript
const url = new URL(
    "http://localhost/api/cloud/files/download"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "molestiae",
    "path": "quia",
    "subor": "sunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/cloud/files/download`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API token usera
        `path` | string |  optional  | optional Cesta kde sa nachadza
        `subor` | file |  required  | Subor
    
<!-- END_987bd0ea20cc84f61f20320ddc6bded8 -->

#Friends


<!-- START_0b5acdf6770ce5d9c40580171d0299d8 -->
## Zobraz priatelov
Funkcia ziska priatelov&lt;br&gt;
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
200 - ok

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/mess/friends" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"ullam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/mess/friends"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "ullam"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/mess/friends`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API Token usera
    
<!-- END_0b5acdf6770ce5d9c40580171d0299d8 -->

<!-- START_1185a33796586559a4c58776f279a650 -->
## Pridat priatela
Funkcia prida priatela&lt;br&gt;
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
421 - priatel neexistuje&lt;br&gt;
200 - ok&lt;br&gt;

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/mess/friends/add" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"nobis","id":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/mess/friends/add"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "nobis",
    "id": 4
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/mess/friends/add`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API Token usera
        `id` | integer |  required  | ID priatela
    
<!-- END_1185a33796586559a4c58776f279a650 -->

#Login


<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## Prihlasenie
Funkcia prihlasi uzivatela vrati mu info&lt;br&gt;
Status kody:&lt;br&gt;
402 - zle udaje&lt;br&gt;
200 - ok&lt;br&gt;

> Example request:

```bash
curl -X POST \
    "http://localhost/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"id","password":"velit"}'

```

```javascript
const url = new URL(
    "http://localhost/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "id",
    "password": "velit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | Prihlasovaci email
        `password` | string |  required  | Heslo uzivatela
    
<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

#Message


<!-- START_b963ce6c981286d7557462085495f492 -->
## Odoslanie spravy
Funkcia vytvori spravu a odosle&lt;br&gt;
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
421 - prijmatel neexistuje&lt;br&gt;
422 - prazdna sprava&lt;br&gt;
200 - ok

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/mess/send" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"dolor","id":2,"message":"perferendis"}'

```

```javascript
const url = new URL(
    "http://localhost/api/mess/send"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "dolor",
    "id": 2,
    "message": "perferendis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/mess/send`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API Token usera
        `id` | integer |  required  | ID prijmatela
        `message` | string |  required  | Sprava
    
<!-- END_b963ce6c981286d7557462085495f492 -->

<!-- START_468fb1049c2ae1e4edcaff93cff201b1 -->
## Ziskat spravy
Funkcia ziska spravy s priatelom&lt;br&gt;
Status kody:&lt;br&gt;
420 - neplatny token&lt;br&gt;
421 - prijmatel neexistuje&lt;br&gt;
422 - neplatny pocet sprav&lt;br&gt;
200 - ok

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/mess" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"est","id":14,"amount":22804771}'

```

```javascript
const url = new URL(
    "http://localhost/api/mess"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "est",
    "id": 14,
    "amount": 22804771
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/mess`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  required  | API Token usera
        `id` | integer |  required  | ID prijmatela
        `amount` | number |  required  | Mnozstvo sprav
    
<!-- END_468fb1049c2ae1e4edcaff93cff201b1 -->

#Postman


<!-- START_b9959acd995a954a578c5e346a670c5c -->
## CSRF
Vrati CSRF token

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/csrf" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/csrf"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/csrf`


<!-- END_b9959acd995a954a578c5e346a670c5c -->

#Register


<!-- START_781ad1ad01e05cc8a932e20631904ba7 -->
## Generuj token
funkcia vygeneruje novy token na registraciu&lt;br&gt;
Status kody:&lt;br&gt;
304 - Unauthorized&lt;br&gt;
200 - ok&lt;br&gt;

> Example request:

```bash
curl -X POST \
    "http://localhost/api/regToken" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"api_token":"autem"}'

```

```javascript
const url = new URL(
    "http://localhost/api/regToken"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_token": "autem"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/regToken`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `api_token` | string |  optional  | Token admina
    
<!-- END_781ad1ad01e05cc8a932e20631904ba7 -->

<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## Registracia
Funkcia registruje noveho uzivatela&lt;br&gt;
Status kody:&lt;br&gt;
420 - uzivatel existuje&lt;br&gt;
421 - neplatny token&lt;br&gt;
422 - Chybaju data&lt;br&gt;
450 - neviem vytvorit subor&lt;br&gt;
200 - ok

> Example request:

```bash
curl -X POST \
    "http://localhost/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"first_name":"est","last_name":"quia","email":"ea","password":"ex"}'

```

```javascript
const url = new URL(
    "http://localhost/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "est",
    "last_name": "quia",
    "email": "ea",
    "password": "ex"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `first_name` | string |  required  | Meno
        `last_name` | string |  required  | Priezvisko
        `email` | string |  required  | E-mail
        `password` | string |  required  | Heslo
    
<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->


