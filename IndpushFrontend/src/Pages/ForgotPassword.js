import React, { useEffect, useState } from 'react'
import { apiURI } from '../utils/common'
import { toast } from 'react-toastify';


function ForgotPassword() {

    const [formData, setFormData] = useState({});

    async function hitApin(e){
        e.preventDefault();

        const URL = apiURI+ '/reset-password-mail';
        localStorage.setItem('user-email', formData.email)
        // const Email = "rohitsesodia@gmail.com";

        // const formData = {
        //     email: Email
        // };

        const responce = await fetch(URL, {
            method:'post',
            body:new URLSearchParams(formData),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }
        });

        const data = await responce.json();
        toast.success(data.message)
        console.log(data)

    }

function handleChange(e){
    const name = e.target.name;
    const value = e.target.value;
    setFormData({...formData, [name]: value});

}

function populateEmail(){
    var url = window.location.href;
    var urlParams = new URLSearchParams(url.split('?')[1]); // Split the URL to get the query string
    var emailParam = urlParams.get('email');
    setFormData({...formData, email: emailParam});
    // console.log(emailParam)
}
 useEffect(()=>{
    populateEmail()
 },[])

    // hitApin();

  return (
    <>
        <div className='middle_login'>
            <div className='middle_login_inner'>
                <div className='custom-block bg-white'>
                        <h3 className="mb-3"><a href="/">LOGO</a></h3>
                        <form className="custom-form profile-form" onSubmit={hitApin}>
             <input className="form-control" value={formData.email}  type="text" name="email" onChange={handleChange}  placeholder="Email Id" />
             <button type="submit" className="form-control ms-2" >Submit</button> 
            </form>
               
                </div>
            </div>
        </div>
    </>
  )
}

export default ForgotPassword