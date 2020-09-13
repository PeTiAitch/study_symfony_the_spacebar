$(document).ready(() => {
    $('.js-user-autocomplete').autocomplete({ hint: false }, [
        {
            source: function (query, cb) {
                cb([
                    { value: 'foo' },
                    { value: 'bar' }
                ])
            }
        }
    ]);
});