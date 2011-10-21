function getDocHeight() { //http://james.padolsey.com/javascript/get-document-height-cross-browser/
            return Math.max(
                document.getElementById('main-coluna-a-1').offsetHeight , document.getElementById('main-coluna-c-1').offsetHeight 
            );
        }
/*document.getElementById('main-coluna-b-1').style.height = document.getElementById('main-coluna-a-1').offsetHeight + 'px';*/

document.getElementById('main-coluna-b-1').style.height = getDocHeight() + 'px';