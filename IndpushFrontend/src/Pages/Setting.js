import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux';
import { apiURI } from '../utils/common';

function Setting() {
    const user = useSelector((state) => state.user.user);
    const [formData, setFormData] = useState({});
    console.log(user)

   async function hitApi(){
       const URL = apiURI+ '/firebase-data';
       const userID = user.id;
       const responce = await fetch(URL, {
        method:'post',
        body:new URLSearchParams({userId:userID}),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            }
       });
       const data = await responce.json();
       if(data.data){
        setFormData(data.data);
       }
    }
    
    async function firebasedataUploadApi(e){
        e.preventDefault();
        const URL = apiURI+ '/firebase-data-upload';
        const finalData = {...formData, userId: user.id}
        // const userID = user.id;
        console.log(finalData);

        const responce = await fetch(URL, {
            method:'post',
            body:new URLSearchParams(finalData),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }
           });
        const data = await responce.json();
        console.log(data)
    }
    function handleChange(e){
        const name = e.target.name;
        const value = e.target.value;
        setFormData({...formData, [name]: value});
    }

    useEffect(()=>{
        hitApi()
    },[])

  return (
    <div>
        <div className='middle_login'>
            <div className='middle_login_inner'>
                <div className='custom-block bg-white'>
                <form className="custom-form profile-form" onSubmit={firebasedataUploadApi}>
                    <textarea className='form-control'  value={formData.config}  name="config" onChange={handleChange} placeholder='Config' ></textarea>
                    <input className="form-control" type="text"  value={formData.serverkey}  onChange={handleChange} name="serverkey" placeholder="Server key" />
                    <input className="form-control" type="text"  value={formData.vapid} onChange={handleChange} name="vapid"  placeholder="VapID" />
                    <button type="submit" className="form-control ms-2" >Submit</button> 
                </form>
                </div>
            </div>
        </div>
    </div>
  )
}

export default Setting