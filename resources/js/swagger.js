import SwaggerUI from 'swagger-ui-dist/swagger-ui-bundle.js';
import 'swagger-ui-dist/swagger-ui.css';
const element = document.getElementById('swagger-ui');
if (element) SwaggerUI({dom_id:'#swagger-ui',url:element.dataset.specUrl,persistAuthorization:false,validatorUrl:null,deepLinking:true,displayRequestDuration:true});
