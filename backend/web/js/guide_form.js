/**
 * Created by melle on 16-6-2017.
 */
function previewImg(input) {
    var imgPreview = $(".guide-item-image");
    if(imgPreview.length > 0) {
        imgPreview.remove();
    }
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        var img = $("<img class='guide-item-image center-block img-responsive' alt='guide image'/>");
        $(".guide-item-content").before(img);

        reader.onload = function (e) {
            img.attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function setSneakPeek(value) {
    var sneak_peek = $(".guide-item-sneak-peek");
    if(sneak_peek.length > 0) {
        sneak_peek.remove();
    }

    if(value !== "") {
        $(".guide-item-info").after("<p class='guide-item-sneak-peek'>"+value+"</p>");
    }
}

function setCategories(selectedItems) {
    console.log(selectedItems);
    var guideCategories = $(".guide-item-categories");

    if(guideCategories.length > 0) {
        guideCategories.remove();
    }

    if(selectedItems.length > 0) {
        guideCategories = $("<div class='guide-item-categories'><span class='mdi mdi-tag'></span> <small></small></div>");
        var small = guideCategories.find('small');
        for(var i = 0;i < selectedItems.length;i++) {
            small.append("<div class='label label-primary'>"+selectedItems[i].text+"</div> ");
        }
        $(".guide-item-time").after(guideCategories);
    }
}

function uploadFile(file, callback) {
    var formData = new FormData();
    formData.append("pastedImage", file);
    formData.append(yii.getCsrfParam(), yii.getCsrfToken());
    $.ajax({
        type: "POST",
        url: "/resources/upload-guide-image",
        data: formData,
        processData: false,
        contentType: false
    }).done(callback);
}

function handlePaste(e) {
    console.log("Handling paste");
    if(e.clipboardData) {
        console.log("Has clipboardData");
        var items = e.clipboardData.items;
        if(!items) return;
        console.log("has items");
        // access data directly
        for(var i = 0; i < items.length;i++) {
            var item = items[i];
            console.log("item "+i+": "+item.kind+" | "+item.type);
            // check if the word image is in mime type
            if(item.type.indexOf("image") !== -1) {
                console.log("item is an image");
                var blob = item.getAsFile();
                if(blob) console.log(blob.name);
                uploadFile(blob, function(response) {
                    if(response) {
                        insertAtCursor(document.getElementById('guide-guide_text'), response);
                    }
                });
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    var img = document.getElementById('uploadImagePreview');
                    img.src = e.target.result;
                    $('#paste-image-modal').modal('show');
                };
                fileReader.readAsDataURL(blob);
            }
        }
        e.preventDefault();
    }
}

function insertAtCursor(element, text) {
    //IE support
    if (document.selection) {
        element.focus();
        sel = document.selection.createRange();
        sel.text = text;
    }
    //MOZILLA and others
    else if (element.selectionStart || element.selectionStart === '0') {
        var startPos = element.selectionStart;
        var endPos = element.selectionEnd;
        element.value = element.value.substring(0, startPos)
            + text
            + element.value.substring(endPos, element.value.length);
    } else {
        element.value += text;
    }
}

function handleDrop(e) {
    e.preventDefault();
    console.log(e);
    var droppedFiles = e.target.files || e.dataTransfer.files;
    console.log(droppedFiles);
}

(function() {
    // set event handler when user pastes something on the screen
    document.addEventListener('paste', handlePaste, false);
    document.addEventListener('ondrop', handleDrop, false);
    $('body').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
}());
