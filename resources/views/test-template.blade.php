<!DOCTYPE html>
<html>
<head>
    <title>Test Template</title>
</head>
<body>
    <h1>Testing Blade Template</h1>
    
    <h2>Main Menu Test:</h2>
    @foreach(mainMenu() as $menu)
        <p>{{ $menu['title'] ?? $menu['label'] ?? 'No Title' }}</p>
        @if(!empty($menu['child']))
            <ul>
                @foreach($menu['child'] as $child)
                    <li>{{ $child['title'] ?? $child['label'] ?? 'No Title' }}</li>
                @endforeach
            </ul>
        @endif
    @endforeach
    
    <h2>Languages Test:</h2>
    @if (allLanguages()?->where('status', 1)->count() > 1)
        @foreach(allLanguages()?->where('status', 1) as $language)
            <p>{{ $language->name }}</p>
        @endforeach
    @endif
    
    <h2>Session Language:</h2>
    <p>{{ getSessionLanguage() }}</p>
</body>
</html>