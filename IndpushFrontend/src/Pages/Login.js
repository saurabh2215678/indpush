// Pages/Login.js
import React, { useEffect, useRef, useState } from 'react';
import './login.css';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import { useDispatch, useSelector } from 'react-redux';
import { userLogin } from '../Redux/slices/user';
import { handleValidateIputs } from '../utils/common';


const Login = () => {
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
      const apiResp = await dispatch(userLogin(formData));
  
      if(apiResp?.payload?.status === 200){
         toast.success(apiResp.payload.message)
      }else{
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
             <input className="form-control"  onChange={handleFormData}  type="text" name="email"  placeholder="Email Id" />
            
               <input className="form-control" onChange={handleFormData}  type="password" name="password" placeholder="Password" />
               {formData?.email ? 
                  <Link className='mt-1 mb-4 forgot_pass' to={`/forgot-password?email=${formData.email}`}>Forgot password? 1</Link>:
                  <Link  className='mt-1 mb-4 forgot_pass' to={`/forgot-password`}>Forgot password?</Link>
               }

            <div className="d-flex">
               {userLoading ? 
               <button type="button" className="form-control ms-2" >Loading...</button> :
               <button type="submit" className="form-control ms-2" >Login</button>}
            </div>
            <div className="text-center mt-3">
            
    <p>Not a member? <Link to="/signup">Register</Link></p>
    </div>
         </form>
      </div>
   </div>
</div>
);
};
export default Login;