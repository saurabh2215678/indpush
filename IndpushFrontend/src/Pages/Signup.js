import React from 'react'
import './login.css';
import { Link } from 'react-router-dom';

function Signup() {
  return (
    <div className='middle_login'>
   <div className='middle_login_inner'>
      <div className="custom-block bg-white">
         <h3 className='mb-3'>LOGO</h3>
         <form className="custom-form profile-form" onSubmit="">
            <input
               className="form-control"
               type="text"
               name="profile-name"
               id="profile-name"
               placeholder="Name"
               />

            <input
            className="form-control"
            type="text"
            name="profile-name"
            id="profile-name"
            placeholder="Mobile Number"
            />

            <input
            className="form-control"
            type="text"
            name="profile-name"
            id="profile-name"
            placeholder="Email Id"
            />

            <input
               className="form-control"
               type="password"
               name="profile-email"
               id="profile-email"
               placeholder="password"
               />
               <input
               className="form-control"
               type="password"
               name="profile-email"
               id="profile-email"
               placeholder="Reenter Password"
               />
               
            <div className="d-flex">
               <button type="submit" className="form-control ms-2">
               Signup
               </button>
            </div>
            <div class="text-center mt-3">
                <p>already have an  <Link to="/login">account</Link></p>
    </div>
         </form>
      </div>
   </div>
</div>
  )
}

export default Signup