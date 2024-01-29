export const apiURI = 'https://indpush.com/wp-json/api';
export const masterUser = 9;
export const handleValidateIputs = (form, errorArray) => {
    errorArray.forEach(item => {
       const inputItem = form?.current.querySelector(`[name=${item}]`);
       inputItem.setAttribute('resp-error', '');
    });
    
}

export const getExtraData = (dataName, data) => {
    if(data){
        // const jsondata = JSON.parse(data);
        console.log('dataaaa>>', JSON.parse(data));
        return 'jsondata[dataName]';
    }else{
        return '';
    }
}