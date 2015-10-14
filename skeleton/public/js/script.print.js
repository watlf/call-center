/**
 * @param {int} numArticle
 */
function printArticle(numArticle) {
    var article = $('#article-' + numArticle);
    var newWindow = window.open('', '', 'left=50,top=50,width=1000px, height=600px, toolbar=0, scrollbars=1, status=0');

    newWindow.document.write(
        '<html>' +
        '<head><title>Print Article</title></head>' +
        '<body>' +
        article.html() +
        '<input type="button" value="Print" onclick="window.print(); window.close()">' +
        '</body>' +
        '</html>'
    );

    newWindow.document.close();
}