export const apiURI = 'https://indpush.com/wp-json/api';

export const handleValidateIputs = (form, errorArray) => {
    errorArray.forEach(item => {
       const inputItem = form?.current.querySelector(`[name=${item}]`);
       inputItem.setAttribute('resp-error', '');
    });
    
}