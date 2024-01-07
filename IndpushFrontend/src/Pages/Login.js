// Pages/Login.js
import React, { useState } from 'react';
import './login.css'; 
import { apiURI } from '../utils/common';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';


const Login = ({user, setUser}) => {
   const [email, setEmail] = useState('');
   const [password, setPassword] = useState('');
   const navigate = useNavigate();

   if(user){
      navigate('/dashboard');
   }

   const LoginData = async ()=> {

      const result = await fetch(`${apiURI}/login`, {
       method:'post',
       // body: JSON.stringify({name,mobile,email}),
       body: new URLSearchParams({
          email,
          password
       }),
       headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          }
       });
       const data = await result.json();
       // Convert the object to a JSON string
       
       console.log(result)
       console.log('data', data);
       if(result.status ==200){
          const user = JSON.stringify(data);
          localStorage.setItem('user', user);
          setUser(user);
       toast.success(data.message);
         navigate('/dashboard') 
       }
       else{
          toast.error(data.message);
       }
       // Store the JSON string in localStorage under a specific key
       // localStorage.setItem('myDataKey', dataString);
       
       // navigate('/dashboard')
       
    }
   
return (
<div className='middle_login'>
   <div className='middle_login_inner'>
      <div className="custom-block bg-white">
         <h3 className='mb-3'><Link to="/dashboard">LOGO</Link></h3>
         <div className="custom-form profile-form" onSubmit="">
             <input className="form-control" onChange={(e)=>setEmail(e.target.value)}  type="text" name="profile-name" id="profile-name" placeholder="Email Id" />
            
               <input className="form-control" onChange={(e)=>setPassword(e.target.value)}  type="password" name="password" id="password" placeholder="Password" />
                <a className='mt-1 mb-4 forgot_pass' href="#!">Forgot password?</a>
            <div className="d-flex">
               <button type="submit"  onClick={LoginData} className="form-control ms-2">
               Login
               </button>
            </div>
            <div class="text-center mt-3">
            
    <p>Not a member? <Link to="/signup">Register</Link></p>
    </div>
         </div>
      </div>
   </div>
</div>
);
};
export default Login;