import React, { useEffect, useState } from 'react'
import { apiURI } from '../utils/common'
import { useNavigate } from 'react-router-dom';

function ResetPassword() {
    const [formData, setFormData] = useState({});
    const [error, setError] = useState('');
    const navigate = useNavigate();

    function handleChange(e){
        e.preventDefault();
        const name = e.target.name;
        const value = e.target.value;
        setFormData(
            {...formData, [name]: value}
            
            );
        // console.log(formData)
    }
    function handleSubmit(e) {
        e.preventDefault();

        const password = formData.password;
        const confirmPassword = formData['confirm-password'];
        if (password === confirmPassword) {
            // console.log("Password match");
            changePasswordApi()
        } else {
            setError("Passwords do not match. Please try again.");
            console.error("Password mismatch. Error!");
        }
    }
    
    async function hitApi(){
        const URL = apiURI+ '/validate-reset-password-link';
        const passwordlink = "https://indpush.com" + window.location.pathname;
        const useremail= localStorage.getItem('user-email')
        // console.log(passwordlink)
        const responce = await fetch(URL, {
            method:'post',
            body:new URLSearchParams({'password-link':passwordlink, email:useremail}),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }
        });
        const data = await responce.json();
        // console.log(data);
        if(responce.status != 200){
            navigate('/forgot-password')
        }
        // console.log(responce)
    }

   async function changePasswordApi(){
        const URL = apiURI+ '/reset-password';
        const passwordlink = "https://indpush.com/" + window.location.pathname;
        const useremail= localStorage.getItem('user-email');
        const password = formData.password;

        const responce = await fetch(URL, {
            method: 'post',
            body:new URLSearchParams({'password-link':passwordlink, email:useremail, password:password}),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }   
        });
        const data = await responce.json();
        // console.log(data)
        if(responce.status == 200){
            navigate('/login')
        }
    }


    
    useEffect(()=>{
        hitApi()
    },[]);


  return (
    <div>
        <div className='middle_login'>
            <div className='middle_login_inner'>
                <div className='custom-block bg-white'>
                        <h3 className="mb-3"><a href="/">LOGO</a></h3>
                            <form className="custom-form profile-form" onSubmit={handleSubmit} >
                            <input className="form-control" onChange={handleChange}  type="text" name="password" placeholder="Password" required />
                            <input className="form-control" onChange={handleChange}  type="text" name="confirm-password" placeholder="confirm-password" required/>
                            <button type="submit" className="form-control ms-2" >Submit</button> 
                            </form>
               
                </div>
            </div>
        </div>
    </div>
  )
}

export default ResetPassword