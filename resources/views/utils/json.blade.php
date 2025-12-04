<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Viewer</title>
    <style>
        body {
            font-family: monospace;
            background-color: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            margin: 0;
        }
        .renderjson a {
            text-decoration: none;
            color: #569cd6;
        }
        .renderjson .disclosure {
            color: #c586c0;
            font-size: 150%;
        }
        .renderjson .string {
            color: #ce9178;
        }
        .renderjson .number {
            color: #b5cea8;
        }
        .renderjson .boolean {
            color: #569cd6;
        }
        .renderjson .key {
            color: #9cdcfe;
        }
        .renderjson .keyword {
            color: #569cd6;
        }
        .renderjson .object.syntax {
            color: #d4d4d4;
        }
        .renderjson .array.syntax {
            color: #d4d4d4;
        }
    </style>
</head>
<body>
    <div id="json-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/renderjson@1.4.0/renderjson.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var data = @json($data);
            renderjson.set_show_to_level(2); // Expand up to 2 levels by default
            document.getElementById('json-container').appendChild(
                renderjson(data)
            );
        });
    </script>
</body>
</html>
