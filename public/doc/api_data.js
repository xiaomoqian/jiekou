define({ "api": [
  {
    "type": "get",
    "url": "/login/login",
    "title": "login",
    "version": "1.0.0",
    "name": "login",
    "group": "login",
    "description": "<p>login</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "strimg",
            "optional": false,
            "field": "password_hash",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "filename": "application/api/controller/v1/LoginController.php",
    "groupTitle": "login",
    "sampleRequest": [
      {
        "url": "http://127.0.0.1:99/api/v1/login/login"
      }
    ]
  }
] });
