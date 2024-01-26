import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux';
import { apiURI } from '../utils/common';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';

function DownloadPlugin() {
    const user = useSelector((state) => state.user.user);
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false)
    const [buttonClick, setbuttonClick] = useState(false)

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
       console.log('jjj', data)
       if(!data.data){
        toast.success(data.message)
        navigate('/setting')
       }
    //    else{
          
    //    }
    }
    function downloadHandler(){
        const userID = user.id;
        setLoading(true);
        // const downloadFile = await fetch(apiURI + `/download-zip?userId=${userID}`)
        setbuttonClick(true);
        console.log(buttonClick)
      setTimeout(() => {
        window.location = apiURI + `/download-zip?userId=${userID}`;
        setLoading(false);
      }, 1000);
      }
    useEffect(()=>{
        hitApi()
    },[user])

  return (
    <div>
        <div className='middle_login'>
            <div className='middle_login_inner'>
                <div className='custom-block bg-white'>
                <div className={loading ? "wait" : 
                buttonClick ? "done":'btn'} onClick={downloadHandler}>{loading ? 'loading' : 'DownloadPlugin'}</div>
                {buttonClick &&
                <>
                     {
                        loading ? <div></div> : <div>Download Success</div>
                     }
                </>
                   
                }
               
            </div>
            </div>
        </div>
    </div>
  )
}

export default DownloadPlugin