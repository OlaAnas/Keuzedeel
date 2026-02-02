<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keuzedeel Login</title>

    <style>
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: radial-gradient(1200px 700px at 20% 20%, rgba(59,130,246,.18), transparent 60%),
                        radial-gradient(900px 600px at 80% 20%, rgba(34,197,94,.12), transparent 55%),
                        linear-gradient(180deg, #0b1220, #070b14);
            color:#e5e7eb;
        }

        .login-card{
            width:min(420px, 92vw);
            background: rgba(17,24,39,.75);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 18px;
            padding: 28px 24px;
            box-shadow: 0 18px 60px rgba(0,0,0,.45);
            backdrop-filter: blur(10px);
        }

        h1{
            margin:0 0 20px;
            text-align:center;
            font-size: 26px;
            letter-spacing:.3px;
        }

        label{
            display:block;
            margin: 14px 0 8px;
            font-size: 13px;
            color: rgba(229,231,235,.8);
        }

        input{
            width:100%;
            box-sizing:border-box;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.10);
            background: rgba(3,7,18,.55);
            color: #e5e7eb;
            outline: none;
        }

        input:focus{
            border-color: rgba(59,130,246,.55);
            box-shadow: 0 0 0 4px rgba(59,130,246,.18);
        }

        button{
            width:100%;
            margin-top: 18px;
            padding: 12px;
            border: 0;
            border-radius: 12px;
            cursor:pointer;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color:white;
            font-weight: 600;
            letter-spacing:.3px;
        }

        button:hover{
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .errors{
            margin-bottom: 14px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.25);
            color: rgba(254,226,226,.95);
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Keuzedeel Inloggen</h1>

        @if ($errors->any())
            <div class="errors">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
