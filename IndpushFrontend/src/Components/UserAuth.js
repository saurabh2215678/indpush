import React, { useEffect } from "react";
import { useDispatch } from "react-redux";
import { userLogin } from "../Redux/slices/user";

const UserAuth = () => {
    const dispatch = useDispatch();
    const handleLogin = async (formData) => {
        const apiResp = await dispatch(userLogin(formData));
        if(apiResp?.payload?.user){
            const respuser = apiResp?.payload?.user;
            localStorage.setItem('userData', JSON.stringify(respuser));
        }
    }

    useEffect(()=>{
        const localStorageUserString = localStorage.getItem('userData');
        const localStorageUser = localStorageUserString ? JSON.parse(localStorageUserString) : {};
        if(localStorageUser && localStorageUser.email && localStorageUser.password){
            const formData = {
                email : localStorageUser.email,
                password: localStorageUser.password
            }
            handleLogin(formData);
        }
        
    });
    return(
        <></>
    );
}

export default UserAuth;