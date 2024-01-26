import React, { useRef, useEffect, useState } from 'react';
import { useSelector, useDispatch } from "react-redux";
import { useNavigate } from "react-router-dom";
import { toast } from "react-toastify";
import { resendOtp, userLogin, verifyOtp } from "../Redux/slices/user";
import { handleValidateIputs } from '../utils/common';

const VerifyAccount = () => {
    const fromRef = useRef();
    const [formData, setFormData] = useState({});
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const user = useSelector((state) => state.user.user);
 
 
     const handleSubmit = async (e)=> {
       e.preventDefault();
       const apiResp = await dispatch(verifyOtp(formData));
   
       if(apiResp?.payload?.status === 200){
          toast.success(apiResp.payload.message);
          const loginUser = await dispatch(userLogin(user));
        //   console.log(loginUser);
          navigate('/dashboard');
       }else{
          toast.error(apiResp.payload.message)
       }
       if(apiResp?.payload?.missing_params){
          handleValidateIputs(fromRef, apiResp?.payload?.missing_params);
       }
       
    }

    useEffect(()=>{
        formData.email = user?.email;
    },[user]);
    
    const handleFormData =(e)=>{
       const name = e.target.name;
       const value = e.target.value;
       setFormData({...formData, [name]: value});
    }

    const resendOtpBtn = async () => {
        const loginUser = await dispatch(resendOtp(formData));
        if(loginUser?.payload?.status === 200){
            toast.success(loginUser.payload.message)
        }else{
            toast.error(loginUser.payload.message)
        }
    }

    return(
        <div>
            <form onSubmit={handleSubmit} ref={fromRef}>
                <input placeholder="email" type="email" onChange={handleFormData} name="email" value={formData?.email ? formData?.email : ''} required />
                <input placeholder="otp" type="text" onChange={handleFormData} name="otp" value={formData?.otp ? formData?.otp : ''} required/>
                <button onClick={resendOtpBtn} type="button">Resend otp</button>
                <button type="submit">Submit otp</button>
            </form>
        </div>
    )
}
export default VerifyAccount; 