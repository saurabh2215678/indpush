import React, { useEffect, useRef, useState } from 'react';
import './login.css';
import { Link, useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { userSignup } from '../Redux/slices/user';
import { toast } from 'react-toastify';
import { handleValidateIputs } from '../utils/common';


function Signup() { 
   const fromRef = useRef();
   const [formData, setFormData] = useState({});
   const dispatch = useDispatch();
   const navigate = useNavigate();
   const user = useSelector((state) => state.user.user);
   const userLoading = useSelector((state) => state.user.loading);

   useEffect(() => {
      if (user) {
        navigate('/dashboard');
      }
    }, [user, navigate]);

   const handleSubmit = async (e)=> {
      e.preventDefault();
      const apiResp = await dispatch(userSignup(formData));
      
      if(apiResp?.payload?.status === 200){
         toast.success(apiResp.payload.message)
         console.log('fsfd1', apiResp);
      }else{
         console.log('fsfd2')
         toast.error(apiResp.payload.message)
      }
      if(apiResp?.payload?.missing_params){
         handleValidateIputs(fromRef, apiResp?.payload?.missing_params);
      }
      
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
         <form className="custom-form profile-form" onSubmit={handleSubmit} ref={fromRef}>
          <input className="form-control" onChange={handleFormData} type="text" name="name" placeholder="Name" /> 
          <input className="form-control" onChange={handleFormData}  type="email" name="email" placeholder="Email Id" />
          
          <input className="form-control" onChange={handleFormData}  type="text" name="domains"  placeholder="Domain Name" />

          <input className="form-control" onChange={handleFormData}  type="text" name="your_domain"  placeholder="Your Domain" />

          <input className="form-control" onChange={handleFormData}  type="password" name="password"  placeholder="Password" /> 
            <div className="d-flex">
               {userLoading ? 
               <button type="button" className="form-control ms-2" >Loading...</button> :
               <button type="submit" className="form-control ms-2" >Signup</button>}
            </div>
            <div className="text-center mt-3">
                <p>already have an  <Link to="/login">account</Link></p>
            </div>
         </form>
      </div>
   </div>
</div>
  )
}

export default Signup