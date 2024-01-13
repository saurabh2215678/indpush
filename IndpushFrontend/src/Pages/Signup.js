import React, { useState } from 'react';
import './login.css';
import { Link, useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { userSignup } from '../Redux/slices/user';



function Signup() { 
   
   const [formData, setFormData] = useState({});
   const dispatch = useDispatch();
   const navigate = useNavigate();
   const user = useSelector((state) => state.user.user);

   if(user){
      navigate('/dashboard');
   }
   const SignupData = (e)=> {
      e.preventDefault();
      dispatch(userSignup(formData));
   }
   
   const handleFormData =(e)=>{
      const name = e.target.name;
      const value = e.target.value;
      setFormData({...formData, [name]: value});
   }

  return (
    <div className='middle_login'>
   <div className='middle_login_inner'>
      <div className="custom-block bg-white">
         <h3 className='mb-3'><Link to="/">LOGO</Link></h3>
         <div className="custom-form profile-form" onSubmit={SignupData}>
         <input className="form-control" onChange={handleFormData} type="text" name="name" placeholder="Name" />
          <input className="form-control" onChange={handleFormData} type="text" name="mobile"  placeholder="Mobile Number" /> 
          <input className="form-control" onChange={handleFormData}  type="text" name="email" placeholder="Email Id" />
          
          <input className="form-control" onChange={handleFormData}  type="text" name="domains"  placeholder="Domain Name" />

          <input className="form-control" onChange={handleFormData}  type="text" name="your_domain"  placeholder="Your Domain" />

          <input className="form-control" onChange={handleFormData}  type="password" name="password"  placeholder="Password" /> 
            <div className="d-flex">
               <button type="submit" className="form-control ms-2">Signup</button>
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