const getCodigoInscripcion = async (incrementar) => {
    return await fetch(URL_BASE_API + "/getCodigoInscripcion/" + incrementar)
        .then((response) => response.json())
        .then(res => res)
        .catch(err => err)
}