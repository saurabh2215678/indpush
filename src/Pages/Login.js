// Pages/Login.js
import React from 'react';
import './login.css'; 
import { Link } from 'react-router-dom';


const Login = () => {
return (
<div className='middle_login'>
   <div className='middle_login_inner'>
      <div className="custom-block bg-white">
         <h3 className='mb-3'><Link to="/dashboard">LOGO</Link></h3>
         <form className="custom-form profile-form" onSubmit="">
            <input
               className="form-control"
               type="text"
               name="profile-name"
               id="profile-name"
               placeholder="User Name"
               />
            <input
               className="form-control mb-0"
               type="password"
               name="profile-email"
               id="profile-email"
               placeholder="password"
               />
                <a className='mt-1 mb-4 forgot_pass' href="#!">Forgot password?</a>
            <div className="d-flex">
               <button type="submit" className="form-control ms-2">
               Login
               </button>
            </div>
            <div class="text-center mt-3">
            
    <p>Not a member? <Link to="/signup">Register</Link></p>
    </div>
         </form>
      </div>
   </div>
</div>
);
};
export default Login;