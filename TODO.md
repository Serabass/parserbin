# TODO List

1. Add `Socialite` support
2. Complete `/me`
3. Add `/{user}/{hash}` support
4. Maybe add `Coffeescript` support
5. Make mobile version
6. Complete `/forgot` page
7. Maybe add Embed parser feature
8. Maybe add `host script on Github` feature
9. **[+]** Style toolbar like `.login-card` (with bg and box-shadow)
10. Redirect to `/` when `/~{hash}` is not exists (or return 404)
11. Try https://github.com/Microsoft/monaco-editor instead of CodeMirror
12. **[+]** Add `Last Execution Time` block
13. Add `Fork` feature by adding `parent_id` field to `parsers`
14. Add `indexable` field to parser. This field must add `<meta name="robots" content="noindex, nofollow" />` if `value === false` and `index` if `true`
15. Add `last_access_at` field. It needed to remove dead parsers (e.g. not accessed in 1 year).
16. Move model interacting to Services and write tests for them
17. Add `type` select that contains: `Line by line`, `Whole file`. First will work as `input` will equal an every line in input string (lines.map), but in case of Second input will equal an entire input string. 
17. Add a feature to use a parser in another parser as shared function. Then I can write like this:
```
// First parser with id /~HylvDLOH2vjk0aKK
return input.replace(input.match(/(\d+)\.(\d+)\.(\d+)(?:.+?(?:(\d+):(\d+)))?/), "$3-$2-$1"); // Reformat a date
```

```
// Second parser

var mySharedParser = @<~HylvDLOH2vjk0aKK>;

return mySharedParser(input);
```

Async loading will be executed before every Evaluate the script and then **@<>** block will be replaced by **function-block**



`/me/parsers` page must contain a list with all user's parsers

`/me/parser/{hash}` page must contain a form with fields:
 * hash
 * name
 * input
 * code
 * is_private (checkbox)
 * indexable (?)
