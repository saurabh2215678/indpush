import React, { useState } from 'react';
import './login.css';
import { Link, useNavigate } from 'react-router-dom';
import { apiURI } from '../utils/common';
import { toast } from 'react-toastify';



function Signup({user, setUser}) {

   const [name, setName] = useState('');
   const [mobile, setMobile] = useState('');
   const [email, setEmail] = useState('');
   const [password, setPassword] = useState('');
   const [domainname, setdomainName] = useState('');
   const [yourdoamin, setYourdoamin] = useState('');

   
   const navigate = useNavigate();
   if(user){
      navigate('/dashboard');
   }

   // const SignupData=()=>{
   //    let signupItem = {name,mobile,email}
   //    console.log(signupItem)  
   //  }
   
  
   const SignupData = async ()=> {

     const result = await fetch(`${apiURI}/signup`, {
      method:'post',
      // body: JSON.stringify({name,mobile,email}),
      body: new URLSearchParams({
         name,
         mobile,
         email,
         password, 
         'domains' : domainname, 
         'your_domain': yourdoamin 
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
         <h3 className='mb-3'>LOGO</h3>
         <div className="custom-form profile-form" onSubmit="">
         <input className="form-control" onChange={(e)=>setName(e.target.value)} type="text" name="profile-name" id="profile-name" placeholder="Name" />
          <input className="form-control" onChange={(e)=>setMobile(e.target.value)} type="text" name="profile-name" id="profile-name" placeholder="Mobile Number" /> 
          <input className="form-control" onChange={(e)=>setEmail(e.target.value)}  type="text" name="profile-name" id="profile-name" placeholder="Email Id" />
          
          <input className="form-control" onChange={(e)=>setdomainName(e.target.value)}  type="text" name="domain" id="domain-name" placeholder="Domain Name" />

          <input className="form-control" onChange={(e)=>setYourdoamin(e.target.value)}  type="text" name="your-domain" id="domain-your" placeholder="Your Domain" />

          <input className="form-control" onChange={(e)=>setPassword(e.target.value)}  type="password" name="password" id="password" placeholder="Password" />
           {/* <input className="form-control" type="password" name="profile-email" id="profile-email" placeholder="password" />
            <input className="form-control" type="password" name="profile-email" id="profile-email" placeholder="Reenter Password" /> */}
               
            <div className="d-flex">
               <button type="submit" onClick={SignupData} className="form-control ms-2">
               Signup
               </button>
            </div>
            <div className="text-center mt-3">
                <p>already have an  <Link to="/login">account</Link></p>
    </div>
         </div>
      </div>
   </div>
</div>
  )
}

export default Signup