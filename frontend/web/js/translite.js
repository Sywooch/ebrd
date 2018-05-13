$('.blog-category-create #blogcategory-name, .blog-post-create #blogpost-name, .blog-event-create #blogevent-name').on('input',function(){
    
    /*
     * @var string The symbol to which all special characters will be replaced
     */
    var space = '-';
    
    /*
     * @var string Take the value from the required field and translate it to the lower case
     */
    var text = $('.blog-category-create #name input, .blog-post-create #name input, .blog-event-create #blogevent-name').val().toLowerCase();
    //var text = document.getElementById('name').value.toLowerCase();	
    /*
     * @var array Array for transliteration
     */
    var transl = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'є': 'e', 'ж': 'zh', 'з': 'z', 'и': 'y',
        'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
        'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh',
        'ь': space, 'і': 'i', 'ю': 'yu', 'я': 'ya', 'ы': 'y',

        ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space, '#': space, '$': space,
        '%': space, '^': space, '&': space, '*': space, '(': space, ')': space, '-': space, '\=': space,
        '+': space, '[': space, ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space,
        '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space, '?': space, '<': space,
        '>': space, '№': space
    }

    var result = '';

    var curent_sim = '';

    for (i = 0; i < text.length; i++) {
        /*
         * @var string If a character is found in an array, then we change it
         */
        if (transl[text[i]] != undefined) {
            if (curent_sim != transl[text[i]] || curent_sim != space) {
                result += transl[text[i]];
                curent_sim = transl[text[i]];
            }
        }
        
        /*
         * @var string If not, we leave it as it is
         */
        else {
            result += text[i];
            curent_sim = text[i];
        }
    }

    result = TrimStr(result);

    /*
     * @var string Output the result
     */
    $('.blog-category-create #blogcategory-alias, .blog-post-create #blogpost-alias,  .blog-event-create #blogevent-alias').val(result);

})
function TrimStr(s) {
    s = s.replace(/^-/, '');
    return s.replace(/-$/, '');
}

$('.blog-category-create #name input, .blog-post-create #name input, .blog-event-create #blogevent-name').on('input', function(){
$('.blog-category-create #page input, .blog-category-create #item input, .blog-post-create #page input, .blog-post-create #item input')
    .val($(this).parents().find('.blog-category-create #name input, .blog-post-create #name input').val());
$('.blog-event-create #blogevent-title')
    .val($('.blog-event-create #blogevent-name').val());
return false;
 });

