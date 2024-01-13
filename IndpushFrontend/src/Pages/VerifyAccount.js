import React from "react";
import { useDispatch } from "react-redux";
import { logout } from "../Redux/slices/user";


const VerifyAccount = () => {

    const dispatch = useDispatch();

    const logOut=()=>{
     dispatch(logout());
    }

    return(
        <>
        <div>Check Your Email and enter your Otp</div>
        <button  onClick={logOut}>Logout</button>
        </>
    )
}
export default VerifyAccount; 