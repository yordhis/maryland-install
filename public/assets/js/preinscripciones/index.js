log('conectado con preincripciones')

let forms = document.forms,
    checkbox_pago = document.querySelectorAll('.checkbox_pago'),
    elemento_informacion_de_pago = document.querySelector('#informacion_pago'),
    html_formacion_pago = `
<div class="relative overflow-x-auto mb-4">
<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-[#c41f2d] dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-4 text-center">
                Métodos de pago
            </th>
            <th scope="col" class="px-6 py-3 text-center">
                Datos
            </th>


        </tr>
    </thead>
    <tbody>
        <tr class="bg-white  dark:bg-gray-800 ">
            <th scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b  dark:border-gray-700">
                Pago movil
            </th>
            <td class="px-6 py-4 border border-t-0 ">
                0414-0000000 <br>
                banco venezuela<br>
                2600000
            </td>

        </tr>
        <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700">
            <th scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border">
                binance
            </th>
            <td class="px-6 py-4  border border-t-0">
                Pay:299898988988<br>
                academia@gmail.com
            </td>


        </tr>
        <tr class="bg-white dark:bg-gray-800 ">
            <th scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                zelle
            </th>
            <td class="px-6 py-4  border border-y-0">
                academia@gmail.com
            </td>

        </tr>
        <tr class="relative">
            <th scope="col" class="px-6 py-4 text-[#c41f2d] text-center border uppercase text-sm ">
                Total a Pagar
            </th>
            <th scope="col" class="py-3 text-[#c41f2d] text-center border  text-lg ">
                180$
            </th>
        </tr>


    </tbody>




</table>


</div>
<!-------subir file--------->
<label
class="flex  w-[240px] mx-auto cursor-pointer appearance-none justify-center rounded-md border border-dashed border-gray-300 bg-white px-3 py-6 text-sm transition hover:border-gray-400 focus:border-solid focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 disabled:cursor-not-allowed disabled:bg-gray-200 disabled:opacity-75"
tabindex="0">
<span for="photo-dropbox" class="flex items-center space-x-2">
    <svg class="h-6 w-6 stroke-gray-400" viewBox="0 0 256 256">
        <path d="M96,208H72A56,56,0,0,1,72,96a57.5,57.5,0,0,1,13.9,1.7" fill="none"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></path>
        <path d="M80,128a80,80,0,1,1,144,48" fill="none" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="24"></path>
        <polyline points="118.1 161.9 152 128 185.9 161.9" fill="none" stroke-linecap="round"
            stroke-linejoin="round" stroke-width="24"></polyline>
        <line x1="152" y1="208" x2="152" y2="128" fill="none"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    </svg>
    <span class="text-xs font-medium text-gray-600">
        subir el comprobante de pago en el formato: png, jpg, jpje
        <span class="text-blue-600 underline">Cargar comprobante</span>
    </span>
</span>
<input id="photo-dropbox" type="file" class="sr-only" />
</label>
`;

log(checkbox_pago)
log(forms)
// $.alert({
//     title:"Alert",
//     content:"un alerta co jquery"
// })

const hanledCheckbox = (e) => {
    log(e.target)
    log(e.target.value)
    if(e.target.value == "pago_en_academia"){
        elemento_informacion_de_pago.innerHTML = "El pago se procesara en la académia."
    }else if(e.target.value == "pago_en_plataforma"){
        elemento_informacion_de_pago.innerHTML = html_formacion_pago;
    }else{
        elemento_informacion_de_pago.innerHTML = "Seleccione una forma de pago."
    }
}


checkbox_pago.forEach(checkbox => {
    checkbox.addEventListener('click', hanledCheckbox);
});
