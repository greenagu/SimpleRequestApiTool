# RequestAPI 프로그램

커맨드 라인을 통해 HTTP 요청을 보내는 프로그램입니다.
HTTP 메소드 (GET, POST, PUT, DELETE)를 지원합니다.

## 요구 사항

- PHP 7 이상이 설치되어 있어야 합니다.

## 설치

1. 이 저장소를 클론하거나 다운로드합니다.
2. 커맨드 라인에서 프로젝트 폴더로 이동합니다.

## 사용법

커맨드 라인에서 다음과 같은 형식으로 프로그램을 실행합니다:
```
php Run.php {auth_key} {http method} {uri} {parameter} {header} {curl options}
```

- `auth_key`: API 요청에 대한 인증 키입니다.
- `http method`: 사용할 HTTP 메소드(GET, POST, PUT, DELETE)를 지정합니다.
- `uri`: 요청을 보낼 대상 URI를 지정합니다.
- `parameter`: 선택 사항으로, 요청에 포함할 매개 변수를 지정합니다.
- `header`: 선택 사항으로, 요청에 포함할 헤더 값을 지정합니다. 여러 개의 헤더를 지정할 경우 쉼표로 구분합니다.
- `curl options`: 선택 사항으로, CURL 옵션을 지정합니다. 여러 개의 옵션을 지정할 경우 쉼표로 구분합니다. 각 옵션은 `key:value` 형식으로 지정합니다.

## 예제

다음은 예제 사용법입니다:

