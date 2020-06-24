    (function () {
        let result = document.getElementById('output');
        // let fileInput = document.getElementById('candidate');
        // let img = document.getElementById("image");
        //
        // fileInput.onchange = makePrediction;

        async function loadModel() {
            result.innerText = 'Loading model... ⏳';
            const m = await tf.loadLayersModel('model/model.json');
            result.innerText = 'Model loaded! 😎';
            return m;
        }

        const model = loadModel();
        console.log(model);

        // function getImageData(img) {
        //     let canvas = document.createElement("canvas");
        //     let ctx = canvas.getContext("2d");
        //     let imageData;
        //     ctx.drawImage(img, 0, 0);
        //     imageData = ctx.getImageData(0, 0, img.width, img.height).data;
        //     console.log("image data:", imageData);
        //
        //     const pixels = tf.browser.fromPixels(img);
        //     //const example = tf.fromPixels();  // for example
        //     const prediction = model.predict(pixels);
        //
        //     console.log(prediction);
        // }
        //
        // function showImage(fileReader) {
        //     img.onload = () => getImageData(img);
        //     img.src = fileReader.result;
        // }
        //
        // function makePrediction(event) {
        //     console.log(event);
        //     if (model) {
        //         let tgt = event.target || window.event.srcElement,
        //             files = tgt.files;
        //
        //         // FileReader support
        //         if (FileReader && files && files.length) {
        //             let fr = new FileReader();
        //             fr.onload = () => showImage(fr);
        //             fr.readAsDataURL(files[0]);
        //         }
        //     }
        // }
    })();

